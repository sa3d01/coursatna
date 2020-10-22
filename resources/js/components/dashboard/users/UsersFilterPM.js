import {fetchData} from "../../commons/NetworkService";

class UsersFilterPM {
    constructor() {
        this.defaultObject = {id: undefined, name: '-- All --'};

        this.countries = [];
        this.init();

        this.urlPrefix = 'dashboard/';
    }

    init() {
        this.governorates = [this.defaultObject];
        this.universities = [this.defaultObject];
        this.faculties = [this.defaultObject];
        this.majors = [this.defaultObject];

        const urlParams = new URLSearchParams(window.location.search);

        this.selectedCountryId = urlParams.has('countryId') ? Number(urlParams.get('countryId')) : undefined;
        this.selectedGovernorateId = urlParams.has('governorateId') ? Number(urlParams.get('governorateId')) : undefined;
        this.selectedUniversityId = urlParams.has('universityId') ? Number(urlParams.get('universityId')) : undefined;
        this.selectedFacultyId = urlParams.has('facultyId') ? Number(urlParams.get('facultyId')) : undefined;
        this.selectedMajorId = urlParams.has('majorId') ? Number(urlParams.get('majorId')) : undefined;
    }

    /*
    /* DATA HYDRATION
    */

    async hydrate() {
        await this.hydrateCountries();
    }

    async hydrateCountries() {
        this.countries = [
            this.defaultObject,
            ...await fetchData(this.urlPrefix + 'json/countries')
        ];
    }

    async hydrateGovernorates() {
        this.governorates = [
            this.defaultObject,
            ...await fetchData(this.urlPrefix + 'json/governorates?countryId=' + this.selectedCountryId)
        ];
    }

    async hydrateUniversities() {
        this.universities = [
            this.defaultObject,
            ...await fetchData(this.urlPrefix + 'json/universities?governorateId=' + this.selectedGovernorateId)
        ];
    }

    async hydrateFaculties() {
        this.faculties = [
            this.defaultObject,
            ...await fetchData(this.urlPrefix + 'json/faculties?universityId=' + this.selectedUniversityId)
        ]
    }

    async hydrateMajors() {
        this.majors = [
            this.defaultObject,
            ...await fetchData(this.urlPrefix + 'json/majors?facultyId=' + this.selectedFacultyId)
        ]
    }

    /*
    /* ON SELECT
    */

    async onCountrySelected() {
        await this.hydrateGovernorates();
    }

    async onGovernorateSelected() {
        this.selectedUniversityId = undefined;
        this.selectedFacultyId = undefined;
        this.selectedMajorId = undefined;
        if (this.selectedGovernorateId) {
            await this.hydrateUniversities();
        }
    }

    async onUniversitySelected() {
        this.selectedFacultyId = undefined;
        this.selectedMajorId = undefined;
        if (this.selectedUniversityId) {
            await this.hydrateFaculties();
        }
    }

    async onFacultySelected() {
        this.selectedMajorId = undefined;
        if (this.selectedFacultyId) {
            await this.hydrateMajors();
        }
    }

    onMajorSelected() {
        //this.selectedMajorId = _event.target.value;

    }

    /*
    /* ACTIONS
    */

    onExport() {
        const url = this.createFilterUrl();
        window.location.replace(window.location.origin + window.location.pathname + '/export' + url);
    }

    onReset() {
        this.init();
    }

    onFilter() {
        const url = this.createFilterUrl();
        window.location.replace(url);
    }

    createFilterUrl() {
        if (this.selectedMajorId) {
            return '?majorId=' + this.selectedMajorId;
        }
        if (this.selectedFacultyId) {
            return '?facultyId=' + this.selectedFacultyId;
        }
        if (this.selectedUniversityId) {
            return '?universityId=' + this.selectedUniversityId;
        }
        if (this.selectedGovernorateId) {
            return '?governorateId=' + this.selectedGovernorateId;
        }
        return '';
    }

}

export default UsersFilterPM;
