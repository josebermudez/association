<template>
  <sweet-modal ref="modal">
    <form @submit.prevent="submit">
      <div class="form-row">
        <!-- Name -->
        <div class="form-group col-md-6">
          <label for="inputName">{{ $t('affiliates.labels.name') }}</label>
          <input
            id="inputName"
            type="string"
            class="form-control"
            :class="{ 'is-invalid': $v.newRecord.name.$error }"
            @change="$v.newRecord.name.$touch()"
            v-model.trim="newRecord.name"
          />
          <div v-if="$v.newRecord.name.$error">
            <span v-if="!$v.newRecord.name.required" class="help-block help-block-error">
              {{ $t('general.labels.required') }}
            </span>
            <span v-if="!$v.newRecord.name.minLength" class="help-block help-block-error">
              {{ $t('general.labels.minlength', {minlength: $v.newRecord.name.$params.minLength.min}) }}
            </span>
            <span v-if="!$v.newRecord.name.maxLength" class="help-block help-block-error">
              {{ $t('general.labels.maxlength', {maxlength: $v.newRecord.name.$params.maxLength.max}) }}
            </span>
          </div>
        </div>
        <!-- End Name -->
         <!-- Last Name -->
        <div class="form-group col-md-6">
          <label for="inputLastName">{{ $t('affiliates.labels.last_name') }}</label>
          <input
            id="inputLastName"
            type="string"
            class="form-control"
            :class="{ 'is-invalid': $v.newRecord.last_name.$error }"
            @change="$v.newRecord.last_name.$touch()"
            v-model.trim="newRecord.last_name"
          />
          <div v-if="$v.newRecord.last_name.$error">
            <span v-if="!$v.newRecord.last_name.required" class="help-block help-block-error">
        {{ $t('general.labels.required') }}
            </span>
            <span v-if="!$v.newRecord.last_name.minLength" class="help-block help-block-error">
              {{ $t('general.labels.minlength', {minlength: $v.newRecord.last_name.$params.minLength.min}) }}
            </span>
      <span v-if="!$v.newRecord.last_name.maxLength" class="help-block help-block-error">
              {{ $t('general.labels.maxlength', {maxlength: $v.newRecord.last_name.$params.maxLength.max}) }}
            </span>
          </div>
        </div>
        <!-- End Last Name -->
      </div>

      <div class="form-row">
        <!-- address -->
        <div class="form-group col-md-6">
          <label for="inputAddress">{{ $t('affiliates.labels.address') }}</label>
          <input
            id="inputAddress"
            type="string"
            class="form-control"
            :class="{ 'is-invalid': $v.newRecord.address.$error }"
            @change="$v.newRecord.address.$touch()"
            v-model.trim="newRecord.address"
          />
          <div v-if="$v.newRecord.address.$error">
            <span v-if="!$v.newRecord.address.required" class="help-block help-block-error">
              {{ $t('general.labels.required') }}
            </span>
            <span v-if="!$v.newRecord.address.minLength" class="help-block help-block-error">
              {{ $t('general.labels.minlength', {minlength: $v.newRecord.address.$params.minLength.min}) }}
            </span>
            <span v-if="!$v.newRecord.address.maxLength" class="help-block help-block-error">
              {{ $t('general.labels.maxlength', {maxlength: $v.newRecord.address.$params.maxLength.max}) }}
            </span>
          </div>
        </div>
        <!-- End address -->
         <!-- Email -->
        <div class="form-group col-md-6">
          <label for="inputEmail">{{ $t('affiliates.labels.email') }}</label>
          <input
            id="inputEmail"
            type="email"
            class="form-control"
            :class="{ 'is-invalid': $v.newRecord.email.$error }"
            @change="$v.newRecord.email.$touch()"
            v-model.trim="newRecord.email"
          />
          <div v-if="$v.newRecord.email.$error">
            <span v-if="!$v.newRecord.email.required" class="help-block help-block-error">
             {{ $t('general.labels.required') }}
            </span>
            <span v-if="!$v.newRecord.email.email" class="help-block help-block-error">
              {{ $t('general.labels.wrong_email_format') }}
            </span>
          </div>
        </div>
        <!-- End Last Name -->
      </div>

      <div class="form-row">
        <!-- phone -->
        <div class="form-group col-md-6">
          <label for="inputPhone">{{ $t('affiliates.labels.phone') }}</label>
          <input
            id="inputPhone"
            type="string"
            class="form-control"
            :class="{ 'is-invalid': $v.newRecord.phone.$error }"
            @change="$v.newRecord.phone.$touch()"
            v-model.trim="newRecord.phone"
          />
          <div v-if="$v.newRecord.phone.$error">
            <span v-if="!$v.newRecord.phone.required" class="help-block help-block-error">
              {{ $t('general.labels.required') }}
            </span>
            <span v-if="!$v.newRecord.phone.minLength" class="help-block help-block-error">
              {{ $t('general.labels.minlength', {minlength: $v.newRecord.phone.$params.minlength.min}) }}
            </span>
            <span v-if="!$v.newRecord.phone.maxLength" class="help-block help-block-error">
              {{ $t('general.labels.maxlength', {maxlength: $v.newRecord.phone.$params.maxLength.max}) }}
            </span>
          </div>
        </div>
        <!-- End phone -->

         <!-- Cell Phone -->
        <div class="form-group col-md-6">
          <label for="inputCellPhone">{{ $t('affiliates.labels.cell_phone') }}</label>
          <input
            id="inputCellPhone"
            type="cell_phone"
            class="form-control"
            :class="{ 'is-invalid': $v.newRecord.cell_phone.$error }"
            @change="$v.newRecord.cell_phone.$touch()"
            v-model.trim="newRecord.cell_phone"
          />
          <div v-if="$v.newRecord.cell_phone.$error">
            <span v-if="!$v.newRecord.cell_phone.required" class="help-block help-block-error">
             {{ $t('general.labels.required') }}
            </span>
             <span v-if="!$v.newRecord.cell_phone.minLength" class="help-block help-block-error">
              {{ $t('general.labels.minlength', {minlength: $v.newRecord.cell_phone.$params.minLength.min}) }}
            </span>
            <span v-if="!$v.newRecord.cell_phone.maxLength" class="help-block help-block-error">
              {{ $t('general.labels.maxlength', {maxlength: $v.newRecord.cell_phone.$params.maxLength.max}) }}
            </span>
          </div>
        </div>
        <!-- End Cell Phone -->
      </div>

      <div class="form-row">
        <!-- birthday -->
        <div class="form-group col-md-6">
          <label for="inputBirthday">{{ $t('affiliates.labels.birthday') }}</label>
          <datepicker 
            id="inputBirthday"
            :format="format" 
            input-class="form-control"
            :class="{ 'is-invalid': $v.newRecord.birthday.$error }"
            @change="$v.newRecord.birthday.$touch()"
            v-model.trim="newRecord.birthday"
            :disabled-dates="newRecord.disabledDates"
            :open-date="newRecord.birthdayOpenDate"
            :language="es"
          />
          <div v-if="$v.newRecord.birthday.$error">
            <span v-if="!$v.newRecord.birthday.required" class="help-block help-block-error">
              {{ $t('general.labels.required') }}
            </span>
          </div>
        </div>
        <!-- End birthday -->

         <!-- Occupation -->
        <div class="form-group col-md-6">
          <label for="inputOccupation">{{ $t('affiliates.labels.occupation') }}</label>
          <input
            id="inputOccupation"
            type="string"
            class="form-control"
            :class="{ 'is-invalid': $v.newRecord.occupation.$error }"
            @change="$v.newRecord.occupation.$touch()"
            v-model.trim="newRecord.occupation"
          />
          <div v-if="$v.newRecord.occupation.$error">
            <span v-if="!$v.newRecord.occupation.required" class="help-block help-block-error">
             {{ $t('general.labels.required') }}
            </span>
             <span v-if="!$v.newRecord.occupation.minLength" class="help-block help-block-error">
              {{ $t('general.labels.minlength', {minlength: $v.newRecord.occupation.$params.minLength}) }}
            </span>
            <span v-if="!$v.newRecord.occupation.maxLength" class="help-block help-block-error">
              {{ $t('general.labels.maxlength', {maxlength: $v.newRecord.occupation.$params.maxLength.max}) }}
            </span>
          </div>
        </div>
        <!-- End Occupation -->
      </div>

      <div class="form-row">
        <!-- marital status -->
        <div class="form-group col-md-6">
          <label for="inputMaritalStatus">{{ $t('affiliates.labels.marital_status') }}</label>

            <select
              id="inputMaritalStatus"
              class="custom-select"
              v-model.trim="newRecord.marital_status"
              required
            >
              <option v-for="maritalStatus in newRecord.maritalStatus" :value="maritalStatus.id" :key="maritalStatus.id">{{ $t(maritalStatus.name) }}</option>
            </select>
         
        </div>
        <!-- End marital status -->
         <!-- number of children -->
        <div class="form-group col-md-6">
          <label for="inputNumberOfChildren">{{ $t('affiliates.labels.number_of_children') }}</label>
          <input
            id="inputNumberOfChildren"
            type="string"
            class="form-control"
            :class="{ 'is-invalid': $v.newRecord.number_of_children.$error }"
            @change="$v.newRecord.number_of_children.$touch()"
            v-model.trim="newRecord.number_of_children"
          />
          <div v-if="$v.newRecord.number_of_children.$error">
            <span v-if="!$v.newRecord.number_of_children.required" class="help-block help-block-error">
             {{ $t('general.labels.required') }}
            </span>
            <span v-if="!$v.newRecord.number_of_children.maxValue" class="help-block help-block-error">
              {{ $t('general.labels.maxvalue', {maxvalue: $v.newRecord.number_of_children.$params.maxValue.max}) }}
            </span>
          </div>
        </div>
        <!-- End number_of_children -->
      </div>

      <div class="form-row">
        <label for="inputTypeAffiliated">{{ $t('affiliates.labels.types') }}</label>
        <!-- Type -->
        <div class="form-group col-md-6">
           <select
            id="inputTypeAffiliated"
            v-model="newRecord.type"
            required
            class="custom-select"
             @change='getManagers()'
          >
          <option v-for="type in newRecord.affiliatedTypes" :value="type.id" :key="type.id">{{ $t(type.name) }}</option>
        </select>
         
        </div>
        <!-- End marital status -->
         <!-- number of children -->
        <div class="form-group col-md-6">
          <label for="inputManager">{{ $t('affiliates.labels.manager') }}</label>
           <select
              id="inputManager"
              class="custom-select"
              v-model.trim="newRecord.manager"
              required
            >
              <option v-for="manager in newRecord.managers" :value="manager.id" :key="manager.id">{{ manager.name }} {{ manager.last_name }} ({{ $t(manager.type) }})</option>
            </select>
        </div>
        <!-- End number_of_children -->
      </div>


      <div class="form-row">
        <!-- Accepted Terms Conditions -->
        <div class="form-check form-check-inline col-md-6">
          <input
            id="inputAcceptedTermsConditions"
            type="checkbox"
            class="form-check-input"
            v-model.trim="newRecord.accepted_terms_conditions"
          >
          <label for="inputAcceptedTermsConditions">{{ $t('affiliates.labels.accepted_terms_conditions') }}</label>
        </div>
        <!-- End accepted Terms Conditions -->
        <!-- Accept Contact B yCellPhone -->
        <div class="form-check form-check-inline col-md-6">
          <input
            id="inputAcceptContactByCellPhone"
            type="checkbox"
            class="form-check-input"
            v-model.trim="newRecord.accept_contact_by_cell_phone"
          >
          <label for="inputAcceptContactByCellPhone">{{ $t('affiliates.labels.accept_contact_by_cell_phone') }}</label>
        </div>
        <!-- End Accept Contact B yCellPhone -->
      </div>

          <div class="form-row">
        <!-- Accept Contact By Phone -->
        <div class="form-check form-check-inline col-md-6">
          <input
            id="inputAcceptContactByPhone"
            type="checkbox"
            class="form-check-input"
            v-model.trim="newRecord.accept_contact_by_phone"
          >
          <label for="inputAcceptContactByPhone">{{ $t('affiliates.labels.accept_contact_by_phone') }}</label>
        </div>
        <!-- End Accept Contact By Phone -->
        <!-- Accept Contact By Email -->
        <div class="form-check form-check-inline col-md-6">
          <input
            id="inputAcceptContactByEmail"
            type="checkbox"
            class="form-check-input"
            v-model.trim="newRecord.accept_contact_by_email"
          >
          <label for="inputAcceptContactByEmail">{{ $t('affiliates.labels.accept_contact_by_email') }}</label>
        </div>
        <!-- End Accept Contact By Email -->
      </div>
    </form>
    <button
      slot="button"
      type="button"
      class="btn btn-default"
      data-dismiss="modal"
      @click="closeModal"
    >
      {{ $t('general.labels.cancel') }}
    </button>

    <button
      slot="button"
      type="submit"
      class="btn btn-primary"
	    :disabled="submitStatus === 'PENDING'"
	    @click="submit"
    >
      {{ $t('general.labels.save') }}
    </button>
	
	<p class="typo__p" v-if="submitStatus === 'ERROR'">{{ $t('general.labels.please_fill_form') }}</p>
	<p class="typo__p" v-if="submitStatus === 'PENDING'">{{ $t('general.labels.saving') }}</p>
	
  </sweet-modal>
</template>

<script>
import { SweetModal } from 'sweet-modal-vue'
import { required, minLength, maxLength, between, email, numeric, maxValue } from 'vuelidate/lib/validators'
import Datepicker from 'vuejs-datepicker'
import {en, es} from 'vuejs-datepicker/dist/locale'
import moment from 'vue-moment'
import Multiselect from 'vue-multiselect'

export default {
  data () {
    return {
      en: en,
      es: es,
  	  newRecord: {
  	    name: '',
        last_name: '',
        email: '',
        address: '',
        phone: '',
        cell_phone: '',
        birthday: '',
        occupation: '',
        marital_status: '',
        number_of_children: 0,
        accepted_terms_conditions: false,
        accept_contact_by_cell_phone: false,
        accept_contact_by_phone: false,
        accept_contact_by_email: false,
        disabledDates: {
          ranges: [{ // Disable dates in given ranges (exclusive).
            from: this.$moment().subtract(300, 'years'),
            to: this.$moment().subtract(90, 'years')
          }, {
            from: this.$moment().subtract(15, 'years'),
            to: this.$moment().add(100, 'years')
          }]
        },
        birthdayOpenDate: this.$moment().subtract(15, 'years').toDate(),
        maritalStatus: [
          { name: "general.labels.single", id: 1 },
          { name: "general.labels.married", id: 2 },
          { name: "general.labels.divorced", id: 3 },
          { name: "general.labels.widowed", id: 4 }
        ],
        affiliatedTypes: [
        { name: this.$t('affiliates.labels.type.general'), id: 'general' },
        { name: this.$t('affiliates.labels.type.consultant'), id: 'consultant' },
        { name: this.$t('affiliates.labels.type.helper'), id: 'helper' },
        { name: this.$t('affiliates.labels.type.lead'), id: 'lead' },
        { name: this.$t('affiliates.labels.type.manager'), id: 'manager' }
        ],
        managers: null
  	  },
  	  submitStatus: null,
      format: 'dd/MM/yyyy',
      i18n: {
        select_one_affiliated: this.$t('affiliates.filters.select_one_affiliated'),
        press_to_select: this.$t('affiliates.filters.press_to_select'),
        selected_label: this.$t('affiliates.filters.selected_label'),
        press_to_remove: this.$t('affiliates.filters.press_to_remove'),
      },
	}
  },
  validations: {
	newRecord: {
		name: {
		  required,
		  maxLength: maxLength(100),
		  minLength: minLength(2)
		},
    last_name: {
      required,
      maxLength: maxLength(100),
      minLength: minLength(2)
    },
    address: {
      required,
      maxLength: maxLength(150),
      minLength: minLength(10)
    },
    email: {
      required,
      email
    },
    phone: {
      required,
      maxLength: maxLength(11),
      minLength: minLength(7)
    },
    cell_phone: {
      required,
      maxLength: maxLength(10),
      minLength: minLength(10)
    },
    birthday: {
      required
    },
    occupation: {
      required,
      maxLength: maxLength(100),
      minLength: minLength(2)
    },
    marital_status: {
      required,
      numeric,
      between: between(0,4),
      maxLength: maxLength(1)
    },
    number_of_children: {
      required,
      numeric,
      between: between(0,6),
      maxValue: maxValue(10)
    }
	}
  },
  components: {
    SweetModal,
    Datepicker,
    moment,
    Multiselect
  },
  methods: {
    openModal () {
      this.$refs.modal.open()
    },
    closeModal () {
      this.$refs.modal.close()
    },
	async submit () {
	  this.$v.$touch()
    console.log(this.$v.$invalid)
	  if (this.$v.$invalid) {
	    this.submitStatus = 'ERROR'
	  } else {
  		this.submitStatus = 'PENDING'
  		this.$parent.$refs.blockUi.loading = true
  		let self = this

  		await window.axios.post('/api/admin/affiliates', self.newRecord)
  			 .then(function (response){
  				self.submitStatus = 'OK'

  				self.$parent.$refs.productTable.refresh();

  				self.$refs.modal.close()
  				
  				window.toastr['success'](response.data.message, self.$t('general.success'))
  			 })
  			 .catch(function (error) {
    				window.toastr['error'](self.$t('general.error'), 'Error')
    				console.log(error)
  			 })
  			 .finally(function () {
  				  self.$parent.$refs.blockUi.loading = false
  			 });
	   }
  	},
    getManagers() {
       let self = this
       axios.get('/api/admin/managers/get', {
        params: {
          child_type: this.newRecord.type
        }
      })
      .then(function (response) {
        console.log(response);
         self.newRecord.managers = response.data;
         // Empty the manager
         self.manager = null;
      });    
    }
  }
}
</script>
