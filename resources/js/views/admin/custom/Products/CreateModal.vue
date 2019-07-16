<template>
  <sweet-modal ref="modal">
    <form @submit.prevent="submit">
      <div class="form-group row">
        <label for="inputName" class="col-sm-2 col-form-label">{{ $t('products.labels.name') }}</label>
        <div class="col-sm-10">
          <input
            id="inputName"
            type="string"
            class="form-control"
			:class="{ 'is-invalid': $v.newProduct.name.$error }"
			@change="$v.newProduct.name.$touch()"
			v-model.trim="newProduct.name"
          >
		  <div v-if="$v.newProduct.name.$error">
            <span v-if="!$v.newProduct.name.required" class="help-block help-block-error">
			  {{ $t('general.labels.required') }}
            </span>
            <span v-if="!$v.newProduct.name.minLength" class="help-block help-block-error">
              {{ $t('general.labels.minlength', {minlength: $v.newProduct.name.$params.minLength.min}) }}
            </span>
			<span v-if="!$v.newProduct.name.maxLength" class="help-block help-block-error">
              {{ $t('general.labels.maxlength', {maxlength: $v.newProduct.name.$params.maxLength.max}) }}
            </span>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label for="inputDescription" class="col-sm-2 col-form-label">{{ $t('products.labels.description') }}</label>
        <div class="col-sm-10">
			<textarea 
				class="form-control"
				:class="{ 'is-invalid': $v.newProduct.description.$error }"
				@change="$v.newProduct.description.$touch()"
				v-model.trim="newProduct.description"
			/>
			<div v-if="$v.newProduct.description.$error">
            <span v-if="!$v.newProduct.description.required" class="help-block help-block-error">
			  {{ $t('general.labels.required') }}
            </span>
            <span v-if="!$v.newProduct.description.minLength" class="help-block help-block-error">
              {{ $t('general.labels.minlength', {minlength: $v.newProduct.description.$params.minLength.min}) }}
            </span>
			<span v-if="!$v.newProduct.description.maxLength" class="help-block help-block-error">
              {{ $t('general.labels.maxlength', {maxlength: $v.newProduct.description.$params.maxLength.max}) }}
            </span>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label for="inputStock" class="col-sm-2 col-form-label">
          {{ $t('products.labels.stock') }}
        </label>
        <div class="col-sm-10">
          <input
            id="inputStock"
            type="integer"
			:class="{ 'is-invalid': $v.newProduct.stock.$error }"
			@change="$v.newProduct.stock.$touch()"
			v-model.trim="newProduct.stock"
            class="form-control"
          >
		  <div v-if="$v.newProduct.stock.$error">
            <span v-if="!$v.newProduct.stock.required" class="help-block help-block-error">
			  {{ $t('general.labels.required') }}
            </span>
            <span v-if="!$v.newProduct.stock.minLength" class="help-block help-block-error">
              {{ $t('general.labels.between', {minlength: $v.newProduct.stock.$params.between.min, maxlength: $v.stock.$params.between.min}) }}
            </span>
			<span v-if="!$v.newProduct.stock.maxLength" class="help-block help-block-error">
              {{ $t('general.labels.maxlength', {maxlength: $v.newProduct.stock.$params.maxLength.max}) }}
            </span>
          </div>
        </div>
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
import { required, minLength, maxLength, between } from 'vuelidate/lib/validators'

export default {
  data () {
    return {
	  newProduct: {
	    stock: 0,
	    name: '',
		description: ''
	  },
	  submitStatus: null
	}
  },
  validations: {
	newProduct: {
		stock: {
		  required,
		  maxLength: maxLength(5),
		  minLength: minLength(1),
		  between: between(0, 99999)
		},
		name: {
		  required,
		  maxLength: maxLength(100),
		  minLength: minLength(10)
		},
		description: {
		  required,
		  maxLength: maxLength(600),
		  minLength: minLength(60)
		}
	}
  },
  components: {
    SweetModal
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
	  if (this.$v.$invalid) {
	    this.submitStatus = 'ERROR'
	  } else {
		this.submitStatus = 'PENDING'
		this.$parent.$refs.blockUi.loading = true
		let self = this

		await window.axios.post('/api/admin/products', self.newProduct)
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
