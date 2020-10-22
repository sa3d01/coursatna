<?php


namespace App\Http\Controllers\Api\Asks;

use App\Http\Resources\Ask\SectionDTO;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Ask;
use App\Models\Section;
use Illuminate\Http\Request;


class AskController extends Controller
{

    public function sections(Request $request)
    {
        return SectionDTO::collection(Section::where('level_id',request()->user()->level_id)->paginate());
    }
    public function asks($section_id){
        $asks_count=Ask::where('section_id',$section_id)->count();
        if ($asks_count<1){
            return response()->json([
                'asks_count'=>$asks_count,
            ]);
        }
        $ask=Ask::where('section_id',$section_id)->inRandomOrder()->first();
        $wrong_answers=Answer::where(['ask_id'=>$ask->id,'true_answer'=>0])->inRandomOrder()->take(3)->select('id','answer')->get();
        $correct_answer=Answer::where(['ask_id'=>$ask->id,'true_answer'=>1])->select('id','answer')->first();
        $answers=collect($wrong_answers->push($correct_answer))->shuffle();
        return response()->json([
            'asks_count'=>$asks_count,
            'id'=>$ask->id,
            'question'=>$ask->question,
            'complexity'=>$ask->complexity,
            'answers'=>$answers->all(),
        ]);
    }
    public function check_answer($ask_id,$answer_id){
        $correct_answer=Answer::where(['ask_id'=>$ask_id,'true_answer'=>1])->select('id','answer')->first();
        if($answer_id==$correct_answer['id']){
            return response()->json([
                'status_answer'=>true,
                'correct_answer'=>$correct_answer
            ]);
        }else{
            return response()->json([
                'status_answer'=>false,
                'correct_answer'=>$correct_answer
            ]);
        }

    }
}
