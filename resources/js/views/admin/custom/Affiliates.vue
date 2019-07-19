<template>
  <div class="main-content">
    <crud-page-header :pageActions="pageActions" :principalTitle="principalTitle" :principalLevel="principalLevel" :secondaryLevel="secondaryLevel" ></crud-page-header>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h6>{{ $t("affiliates.labels.all") }}</h6>
            <div class="card-actions" />
          </div>
          <div class="card-body">
            <table-component
              :data="getAll"
              sort-by="created_at"
              sort-order="desc"
              table-class="table"
			  v-bind:filter-no-results="i18n.table.filterNoResults"
			  v-bind:filter-placeholder="i18n.table.filterPlaceholder"
			  ref="dataTable"
            >
              <table-column show="name" v-bind:label="i18n.columns.name"/>
			  <table-column show="last_name" v-bind:label="i18n.columns.last_name"/>
			  <table-column show="cell_phone" v-bind:label="i18n.columns.cell_phone"/>
			  <table-column show="email" v-bind:label="i18n.columns.email"/>
              <table-column show="status" v-bind:label="i18n.columns.status"/>
              <table-column
                show="created_at"
                v-bind:label="i18n.columns.registered_on"
                data-type="date:YYYY-MM-DD h:i:s"
              />
              <table-column
                :sortable="false"
                :filterable="false"
                label=""
              >
                <template slot-scope="row">
                  <div class="table__actions">
                    <a 
					  class="btn btn-default btn-sm"
					  @click="openViewModal(row)"
					>
                      <i class="icon-fa icon-fa-search"/> {{ $t("affiliates.actions.view") }}
                    </a>
                    <a
                      class="btn btn-default btn-sm"
                      data-delete
                      data-confirmation="notie"
                      @click="deleteOne(row)"
                    >
                      <i class="icon-fa icon-fa-trash"/> {{ $t("affiliates.actions.delete") }}
                    </a>
                  </div>
                </template>
              </table-column>
            </table-component>
          </div>
        </div>
      </div>
	  <create-modal ref="create"/>
	  <view-modal ref="view"/>
	  <block-u-i ref="blockUi"/>
	  
    </div>
  </div>
</template>


<script>
import { TableComponent, TableColumn } from 'vue-table-component'
import CreateModal from './affiliated/CreateModal'
import ViewModal from './affiliated/ViewModal'
import BlockUI from '../../../components/custom/BlockUI'
import CrudPageHeader from './partials/CrudPageHeader'

export default {
  components: {
    TableComponent,
    TableColumn,
	CreateModal,
	ViewModal,
	BlockUI,
	CrudPageHeader
  },
  data () {
    return {
	  i18n: {
		  columns: {
			last_name: this.$t('affiliates.labels.last_name'),
			name: this.$t('affiliates.labels.name'),
			cell_phone: this.$t('affiliates.labels.cell_phone'),
			phone: this.$t('affiliates.labels.phone'),
			email: this.$t('affiliates.labels.email'),
			registered_on: this.$t('general.labels.registered_on')
		  },
		table: {
			filterNoResults: this.$t('general.labels.no_rows'),
			filterPlaceholder: this.$t('general.labels.filter_place_holder'),
		}
	  },
	  principalLevel: 'affiliates.affiliates',
	  secondaryLevel: 'general.all',
	  principalTitle: 'affiliates.affiliates',
	  pageActions: {
	    createLabel: 'affiliates.actions.new'
	  }
    }
  },
  methods: {
    async getAll ({ page, filter, sort }) {

		let data
		
		this.$refs.blockUi.loading = true
		let self = this
		
        const response = await axios.get('/api/admin/affiliates/get', { params: {page: page, filter:filter, sort:sort} })
						.then((response) => {
						
							data = {
								data: response.data.data,
								pagination: {
									currentPage: response.data.current_page,
									totalPages: response.data.last_page,
									count: response.data.count
								}
							}	
						}).catch(function (error) {
						  window.toastr['error'](self.$t('general.error'), 'Error')
						  console.log(error)
						})
						.finally(function () {
						  self.$refs.blockUi.loading = false
						})
		return data
    },
    deleteOne (row) {
      let self = this

      window.notie.confirm({
        text: this.$t('general.labels.confirm', { name: row.name }),
        cancelCallback: function () {
          window.toastr['info']('Cancel')
        },
        submitCallback: function () {
          self.deleteData(row.id)
        },
		submitText: this.$t('general.labels.yes'),
		cancelText: this.$t('general.labels.cancel')
      })
    },
    async deleteData (id) {
	
	  this.$refs.blockUi.loading = true
	  let self = this
	  
      await window.axios.delete('/api/admin/affiliates/' + id)
			.then(function (response){
			  self.$refs.dataTable.refresh()
			  window.toastr['success'](response.data.message, self.$t('general.success'))
			})
			.catch(function (error) {
			  window.toastr['error'](self.$t('general.error'), 'Error')
			  console.log(error)
			})
			.finally(function () {
			  self.$refs.blockUi.loading = false
			});
    },
	openCreateModal () {
		this.$refs.create.openModal()
	},
	openViewModal (row) {
		this.$refs.view.openModal(row)
	}
  }
}
</script>