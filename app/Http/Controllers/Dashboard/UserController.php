<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\UserAddBalanceRequest;
use App\Http\Requests\Dashboard\UserStoreRequest;
use App\Http\Requests\Dashboard\UserUpdateRequest;
use App\Models\Faculty;
use App\Models\Governorate;
use App\Models\Level;
use App\Models\University;
use App\Models\User;
use App\Traits\MoneyOperations\MoneyChargerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    use MoneyChargerTrait;

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(Request $request)
    {
        $search_q = '';
        if ($request->has('search_q')) {
            $search_q = $request['search_q'];
        }

        $where = [];
        if ($request->has('majorId')) {
            $where['major_id'] = $request['majorId'];
        }
        if ($request->has('facultyId')) {
            $where['faculty_id'] = $request['facultyId'];
        }
        if ($request->has('universityId')) {
            $where['university_id'] = $request['universityId'];
        }
        if ($request->has('governorateId')) {
            $where['governorate_id'] = $request['governorateId'];
        }
        $users = User::where($where)
            ->where('name', 'LIKE', '%' . $search_q . '%')
            ->orderBy('id', 'desc')
            ->paginate();

        return view('dashboard.users.index')
            ->with('users', $users)
            ->with('total', $users->total())
            ->with('indexUrl', route('dashboard.users.index'));
    }

    public function export(Request $request)
    {
        $fileName = 'users' . time();
        return Excel::download(new UsersExport($this->buildingWhereQuery($request->all())), $fileName . '.xlsx');
    }

    private function buildingWhereQuery($dataArray)
    {
        $where = [];
        if (array_key_exists('majorId', $dataArray)) {
            $where['major_id'] = $dataArray['majorId'];
        }
        if (array_key_exists('facultyId', $dataArray)) {
            $where['faculty_id'] = $dataArray['facultyId'];
        }
        if (array_key_exists('universityId', $dataArray)) {
            $where['university_id'] = $dataArray['universityId'];
        }
        if (array_key_exists('governorateId', $dataArray)) {
            $where['governorate_id'] = $dataArray['governorateId'];
        }
        return $where;
    }

    public function create()
    {
        $governorates = Governorate::where(['country_id' => 1])->get();
        $universities = count($governorates) > 0 ? University::where(['governorate_id' => $governorates->first()->id])->get() : [];
        $faculties = count($universities) > 0 ? Faculty::where(['university_id' => $universities->first()->id])->get() : [];
        return view('dashboard.users.create')
            ->with('roles', Role::all())
            ->with('levels', Level::all())
            ->with('governorates', $governorates)
            ->with('universities', $universities)
            ->with('faculties', $faculties);
    }

    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->validated());

        $data['is_school_student'] = false;
        if ($request->has('role') && $request['role'] == 'SCHOOL_STUDENT') {
            $data['is_school_student'] = true;
        }

        $role = Role::findByName($request['role']);
        if ($role) {
            $user->syncRoles([$request['role']]);
        }
        return redirect()->route('dashboard.users.index')
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(User $user)
    {
        $moneyAccount = $this->getUserMoneyAccount($user);
        return view('dashboard.users.show')
            ->with('user', $user)
            ->with('moneyAccount', $moneyAccount);
    }

    public function edit(User $user)
    {
        $authUser = auth()->user();

        if ($user->isMe) {
            return view('dashboard.users.me')
                ->with('user', $user);
        }

        $canUpdateRole = false;
        if ($authUser->hasRole('SUPER_ADMIN') && $authUser->id != $user->id) {
            $canUpdateRole = true;
        }

        $governorates = Governorate::where(['country_id' => 1])->get();
        $universities = count($governorates) > 0 ? University::where(['governorate_id' => $user->governorate_id])->get() : [];
        $faculties = count($universities) > 0 ? Faculty::where(['university_id' => $user->university_id])->get() : [];

        return view('dashboard.users.edit')
            ->with('user', $user)
            ->with('roles', Role::where('name', '!=', 'SUPER_ADMIN')->get())
            ->with('canUpdateRole', $canUpdateRole)
            ->with('levels', Level::all())
            ->with('governorates', $governorates)
            ->with('universities', $universities)
            ->with('faculties', $faculties);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->all();

        $data['is_school_student'] = false;
        if ($request->has('role') && $request['role'] == 'SCHOOL_STUDENT') {
            $data['is_school_student'] = true;
        }

        $user->update($data);

        if ($request->role && $request->user()->can('edit-users') && !$user->isMe) {
            $role = Role::findByName($request->role);
            if ($role) {
                $user->syncRoles([$role]);
            }
        }

        return redirect()->route('dashboard.users.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(User $user)
    {
        if (!$user['isMe']) {
            $user->delete();
            return response()->json(['message' => 'Deleted Successfully'], 200);
        }
        return response()->json(['message' => 'Cannot be deleted'], 403);
    }

    public function roles()
    {
        return response()->json(Role::all());
    }

    public function addBalanceView(User $user)
    {
        $moneyAccount = $this->getUserMoneyAccount($user);
        return view('dashboard.users.add-balance')
            ->with('user', $user)
            ->with('moneyAccount', $moneyAccount);
    }

    public function addBalance(UserAddBalanceRequest $request, User $user)
    {
        $transaction = $this->addInternalTransaction(auth()->user(), 'User', $user->id, $request->amount);

        $moneyAccount = $this->getUserMoneyAccount($user);
        $moneyAccount->update(['balance' => $moneyAccount->balance + $transaction['amount']]);

        return redirect()->route('dashboard.users.show', $user->id)
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function ban(User $user)
    {
        $banned = $user->banned;
        $user->update(['banned' => !$banned]);
        return redirect()->route('dashboard.users.show', $user->id)
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }
}
