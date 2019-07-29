<template>
  <sweet-modal ref="modal" width="80%">
    
    <filters-affiliated :notification="notification"></filters-affiliated>

  </sweet-modal>
</template>

<script>
import { SweetModal } from 'sweet-modal-vue'
import { required, minLength, maxLength, between, email, numeric, maxValue } from 'vuelidate/lib/validators'
import Datepicker from 'vuejs-datepicker'
import moment from 'vue-moment'
import FiltersAffiliated from '../partials/FiltersAffiliated'

export default {
  data () {
    return {
  	  newRecord: {
  	    name: '',
        from: '',
        message: '',
  	  },
      notification: null,
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
    FiltersAffiliated
  },
  methods: {
    openModal (row) {
      console.log(row)
      this.notification = row;
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
