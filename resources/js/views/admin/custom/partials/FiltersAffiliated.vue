<template> 
  <div>
    <form @submit.prevent="submit" id="filters">
      <div class="form-row">
         <!-- Leader -->
        <div class="form-group col-md-6">
          <label for="inputLeaders">{{ $t('affiliates.filters.labels.leader') }}</label>
           <multiselect
            id="inputLeaders"
            v-model="leaders"
            :options="LeaderOptions"
            :multiple="true"
            :close-on-select="false" 
            :clear-on-select="false" 
            :preserve-search="true" 
            v-bind:placeholder="i18n.select_one_leader" 
            label="name" 
            track-by="name"
            :loading="isLoading"
            :selectLabel="i18n.press_to_select"
            :selectedLabel="i18n.selected_label"
            :deselectLabel="i18n.press_to_remove"
            @search-change="LeaderSearch"
            :custom-label="customLabel"
          >
          <span slot="noOptions">{{ $t('general.labels.list_empty') }}.</span>
          <span slot="noResult">{{ $t('general.labels.no_result') }}.</span>
        </multiselect>
        </div>
        <!-- End Leader -->
         <!-- Name -->
        <div class="form-group col-md-6">
          <label for="inputTypes">{{ $t('affiliates.filters.labels.type') }}</label>
           <multiselect
            id="inputTypes"
            v-model="types"
            :options="MultiOptions"
            :multiple="true"
            :close-on-select="false" 
            :clear-on-select="false" 
            :preserve-search="true" 
            v-bind:placeholder="i18n.select_one_affiliated" 
            label="name" 
            track-by="name"
            :selectLabel="i18n.press_to_select"
            :selectedLabel="i18n.selected_label"
            :deselectLabel="i18n.press_to_remove"
          />
        </div>
        <!-- End Name -->
      </div>

    </form>
    <button
      slot="button"
      type="submit"
      class="btn btn-primary"
	    @click="submit"
      :disabled="submitStatus === 'PENDING'"
    >
      {{ $t('general.labels.search') }}
    </button>
    <button class="btn btn-outline-primary" @click="notieNotifs()">
      {{ $t('general.labels.send_test_sms') }}
    </button>
   
    <button v-if="disabledSmsButton"
      slot="button"
      type="button"
      class="btn btn-warning"
      @click="sendSms()"
    >
      {{ $t('general.labels.send_sms') }}
    </button>
	
	<p class="typo__p" v-if="submitStatus === 'ERROR'">{{ $t('general.labels.please_fill_form') }}</p>
	<p class="typo__p" v-if="submitStatus === 'PENDING'">{{ $t('general.labels.searching') }}</p>

  <div id="table_of_results">
      <div id="app">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>
                <label class="form-checkbox">
          <input type="checkbox" v-model="selectAll" @click="select">
          <i class="form-icon"></i>
        </label>
              </th>
              <th>id</th>
              <th>name</th>
              <th>last Name</th>
              <th>Cell phone</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in items">
              <td>
                <label class="form-checkbox">
                    <input type="checkbox" :value="item.id" v-model="selected">
                  <i class="form-icon"></i>
                  </label>
              </td>
              <td>{{item.id}}</td>
              <td>{{item.name}}</td>
              <td>{{item.last_name}}</td>
              <td>{{item.cell_phone }}</td>
              <td>{{item.email}}</td>
            </tr>
          </tbody>
        </table>
      </div>
  </div>
</div>
</template>

<script>
import { SweetModal } from 'sweet-modal-vue'
import { required, minLength, maxLength, between, email, numeric, maxValue } from 'vuelidate/lib/validators'
import Datepicker from 'vuejs-datepicker'
import moment from 'vue-moment'
import Multiselect from 'vue-multiselect'

export default {
  data () {
    return {
      submitStatus: null,
      types: null,
      LeaderOptions: [],
      leaders: [],
      MultiOptions: [
        { name: this.$t('affiliates.labels.type.general'), id: 'general' },
        { name: this.$t('affiliates.labels.type.lead'), id: 'lead' },
        { name: this.$t('affiliates.labels.type.helper'), id: 'helper' },
        { name: this.$t('affiliates.labels.type.consultant'), id: 'consultant' },
        { name: this.$t('affiliates.labels.type.manager'), id: 'manager' }
      ],
      i18n: {
        select_one_affiliated: this.$t('affiliates.filters.select_one_affiliated'),
        press_to_select: this.$t('affiliates.filters.press_to_select'),
        selected_label: this.$t('affiliates.filters.selected_label'),
        press_to_remove: this.$t('affiliates.filters.press_to_remove'),
      },
      submitStatus: null,
      items: [],
      selected: [],
      selectAll: false,
      disabledTestSmsButton: false,
      isLoading: false
	  }  
  },
  props: {
   notification: {
    required: true
   }
  },
  components: {
    Datepicker,
    moment,
    Multiselect
  },
  methods: {
    notieNotifs() {
      var self = this
      notie.input({
        text: this.$t('notifications.labels.enter_cell_phone'),
        submitText: this.$t('general.labels.submit'),
        cancelText: this.$t('general.labels.cancel'),
        cancelCallback: function (value) {
          window.toastr['warning'](this.$t('notifications.labels.cancel_test_sms'), self.$t('general.labels.warning'))

        },
        submitCallback: function (value) {
          if (value.length < 10) {
            window.toastr['warning'](self.$t('notifications.labels.invalid_phone_number'), self.$t('general.labels.warning'))
          } else {
            self.sendSampleMsg(value)
          }
        },
        value: '',
        type: 'text',
        placeholder: 'xxx xxxx xxxx',
        allowed: ['n'],
        maxlength: 10,
        min: 10
      })
    },
    closeModal () {
      this.$parent.$refs.modal.close()
    },
    selectOne() {
      return this.$t('affiliates.filters.labels.select_one_affiliated');
    },
  async sendSampleMsg(phone) {
    var self = this
    // Send the test message
     await window.axios.post('/api/admin/notifications/send_sample',{params:{ 
      phone: phone,
      id: self.notification.id
    }})
     .then(function (response){
        self.submitStatus = 'OK'
        if (response.data.message) {
          window.toastr['success'](response.data.message, self.$t('general.labels.success'))
        }
     })
     .catch(function (error) {
        window.toastr['error'](self.$t('general.error'), 'Error')
        console.log(error)
     })
     .finally(function () {
     })
  },
  customLabel ({ name, last_name }) {
      return `${name} ${last_name}`
    },
	async submit () {
  	
    this.submitStatus = 'PENDING'
    var self = this;
        await window.axios.get('/api/admin/affiliates/gets',{params:{ 
          types: this.types,
          leaders: this.leaders,
          search_by_notification: true
        }})
  			 .then(function (response){
  				  self.submitStatus = 'OK'
            if (!response.data.length) {
              window.toastr['warning'](self.$t('general.labels.no_rows'), self.$t('general.labels.warning'))
            }

            self.items = response.data;
  			 })
  			 .catch(function (error) {
    				window.toastr['error'](self.$t('general.error'), 'Error')
    				console.log(error)
  			 })
  			 .finally(function () {
  			 });

	},
  async sendSms () {
    
    this.submitStatus = 'PENDING'
    var self = this;
        await window.axios.post('/api/admin/notifications/send_sms',{params:{ 
          affiliates: self.selected,
          notification: self.notification.id
        }})
         .then(function (response) {
            self.submitStatus = 'OK'
            if (response.data.message) {
              window.toastr['success'](response.data.message, self.$t('general.labels.success'))
            }
         })
         .catch(function (error) {
            window.toastr['error'](self.$t('general.error'), 'Error')
            console.log(error)
         })
         .finally(function () {
         });

  },
  select() {
      this.selected = [];
      if (!this.selectAll) {
        for (let i in this.items) {
          this.selected.push(this.items[i].id);
        }
      }
  },
  LeaderSearch(query) {
    let self = this
    if(query.length > 3) {
      this.isLoading = true
      axios.get('/api/admin/managers/get_leaders', { params:
          {query : query}
       })
      .then(function (response) {
        console.log(response);
         self.LeaderOptions = response.data.data;
         self.isLoading = false;
      });      
    }
    
  }
  },
  computed: {
    disabledSmsButton() {
      return this.submitStatus === "OK" && this.items.length && this.selected.length > 0;
    }
  }
}
</script>
