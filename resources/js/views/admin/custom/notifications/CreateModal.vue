<template>
  <sweet-modal ref="modal">
    <form @submit.prevent="submit">
      <div class="form-row">
        <!-- Name -->
        <div class="form-group col-md-6">
          <label for="inputName">{{ $t('notifications.labels.name') }}</label>
          <input
            id="inputName"
            type="string"
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
         <!-- From -->
        <div class="form-group col-md-6">
          <label for="inputFrom">{{ $t('notifications.labels.from') }}</label>
          <input
            id="inputFrom"
            type="string"
            :class="{ 'is-invalid': $v.newRecord.from.$error }"
            @change="$v.newRecord.from.$touch()"
            v-model.trim="newRecord.from"
          />
          <div v-if="$v.newRecord.from.$error">
            <span v-if="!$v.newRecord.from.required" class="help-block help-block-error">
        {{ $t('general.labels.required') }}
            </span>
            <span v-if="!$v.newRecord.from.minLength" class="help-block help-block-error">
              {{ $t('general.labels.minlength', {minlength: $v.newRecord.from.$params.minLength.min}) }}
            </span>
      <span v-if="!$v.newRecord.from.maxLength" class="help-block help-block-error">
              {{ $t('general.labels.maxlength', {maxlength: $v.newRecord.from.$params.maxLength.max}) }}
            </span>
          </div>
        </div>
        <!-- End From -->
      </div>

      <div class="form-row">
        <!-- Message -->
        <div class="form-group col-md-6">
          <label for="inputMessage">{{ $t('notifications.labels.message') }}</label>
          <textarea
              id="inputMessage"
              class="form-control"
              rows="3"
              :class="{ 'is-invalid': $v.newRecord.message.$error }"
              @change="$v.newRecord.message.$touch()"
              v-model.trim="newRecord.message"
          />
          <div v-if="$v.newRecord.message.$error">
            <span v-if="!$v.newRecord.message.required" class="help-block help-block-error">
              {{ $t('general.labels.required') }}
            </span>
            <span v-if="!$v.newRecord.message.minLength" class="help-block help-block-error">
              {{ $t('general.labels.minlength', {minlength: $v.newRecord.message.$params.minLength.min}) }}
            </span>
            <span v-if="!$v.newRecord.message.maxLength" class="help-block help-block-error">
              {{ $t('general.labels.maxlength', {maxlength: $v.newRecord.message.$params.maxLength.max}) }}
            </span>
          </div>
        </div>
        <!-- End Message -->
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
import moment from 'vue-moment'

export default {
  data () {
    return {
  	  newRecord: {
  	    name: '',
        from: '',
        message: '',
  	  },
  	  submitStatus: null
	  }  
  },
  validations: {
	newRecord: {
		name: {
		  required,
		  maxLength: maxLength(100),
		  minLength: minLength(2)
		},
    from: {
      required,
      maxLength: maxLength(10),
      minLength: minLength(10)
    },
    message: {
      required,
      maxLength: maxLength(150),
      minLength: minLength(10)
    }
	}
  },
  components: {
    SweetModal,
    Datepicker,
    moment
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

  		await window.axios.post('/api/admin/notifications', self.newRecord)
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
	}
  }
}
</script>
