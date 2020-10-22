<template>
    <div class="card">
        <div class="card-header">
            <h4>Filter Users</h4>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group  mb-4">
                        <label>Country:</label>
                        <select
                            class="form-control"
                            name="role"
                            v-model="pm.selectedCountryId"
                            @change="pm.onCountrySelected()"
                        >
                            <option
                                v-for="country in pm.countries"
                                :value="country.id"
                            >
                                {{ country.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group  mb-4">
                        <label>Governorate:</label>
                        <select
                            class="form-control"
                            name="role"
                            v-model="pm.selectedGovernorateId"
                            @change="pm.onGovernorateSelected()"
                        >
                            <option
                                v-for="governorate in pm.governorates"
                                :value="governorate.id"
                            >
                                {{ governorate.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group  mb-4">
                        <label>University:</label>
                        <select
                            class="form-control"
                            name="role"
                            v-model="pm.selectedUniversityId"
                            @change="pm.onUniversitySelected()"
                        >
                            <option
                                v-for="university in pm.universities"
                                :value="university.id"
                            >
                                {{ university.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group  mb-4">
                        <label>Faculty:</label>
                        <select
                            class="form-control"
                            name="role"
                            v-model="pm.selectedFacultyId"
                            @change="pm.onFacultySelected()"
                        >
                            <option
                                v-for="faculty in pm.faculties"
                                :value="faculty.id"
                            >
                                {{ faculty.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group  mb-4">
                        <label>Major:</label>
                        <select
                            class="form-control"
                            name="role"
                            v-model="pm.selectedMajorId"
                            @change="pm.onMajorSelected()"
                        >
                            <option
                                v-for="major in pm.majors"
                                :value="major.id"
                            >
                                {{ major.name }}
                            </option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <button class="float-right btn btn-outline-info m-1" @click="pm.onExport()">Export Filtered</button>
                <button class="float-right btn btn-outline-danger m-1" @click="pm.onReset()">Reset</button>
                <button class="float-right btn btn-outline-success m-1" @click="pm.onFilter()">Filter</button>
            </div>

        </div>
    </div>
</template>

<script>
    import UsersFilterPM from "./UsersFilterPM";

    export default {
        name: "UsersFilter",
        async created() {
            this.pm = new UsersFilterPM();
            await this.pm.hydrate();
        },
        data() {
            return {
                pm: undefined,
            }
        }
    }
</script>
