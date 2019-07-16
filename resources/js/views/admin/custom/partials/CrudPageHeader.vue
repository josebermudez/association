<template>
    <div class="page-header">
      <h3 class="page-title" v-if="principalTitle">{{ $t(principalTitle) }}</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">{{ $t("general.home") }}</a></li>
        <li class="breadcrumb-item" v-if="principalLevel"><a href="#">{{ $t(principalLevel) }}</a></li>
        <li class="breadcrumb-item active" v-if="secondaryLevel">{{ $t(secondaryLevel) }}</li>
      </ol>
	  <div v-if="pageActions" class="page-actions">
      
		 <button class="btn btn-primary" @click="openCreateModal" v-if="pageActions.createLabel">
			<i class="icon-fa icon-fa-plus"/> {{ $t(pageActions.createLabel) }}
		 </button>
          
        <button class="btn btn-danger" v-if="pageActions.deleteLabel">
          <i class="icon-fa icon-fa-trash"/> {{ $t(pageActions.deleteLabel) }}
        </button>
      </div>
    </div>
</template>

<script type="text/babel">

export default {
  props: {
	principalTitle: {
		type: String,
		default: ''
	},
	principalLevel: {
		type: String,
		default: ''
	},
	secondaryLevel: {
		type: String,
		default: ''
	},
	pageActions: {
		type: Object,
		default: function() {
			return {
				createLabel: 'general.labels.create',
				deleteLabel: 'general.labels.delete'
			}
		}
	}
  },
  methods: {
	openCreateModal () {
		this.$parent.$refs.create.openModal()
	}
  }
}
</script>
