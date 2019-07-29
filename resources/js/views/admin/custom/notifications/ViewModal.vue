<template>
  <sweet-modal ref="viewModal">
	<div class="card">
              <div class="card-header">
                <div class="caption">
                  <p><strong>{{ $t('notifications.labels.name') }}: </strong><h6>{{ row.name }}</h6>
                </div>
              </div>
              <div class="card-body text-align-left">
                <p><strong>{{ $t('notifications.labels.message') }}: </strong>{{ row.message }}
				</p>
				<p><strong>{{ $t('notifications.labels.from') }}: </strong>{{ row.from }}
				</p>
				<p><strong>{{ $t('general.labels.registered_on') }}: </strong>{{ row.created_at | formatDate }}
				</p>
              </div>
            </div>
  
  </sweet-modal>
</template>

<script>
import { SweetModal } from 'sweet-modal-vue'

export default {
  data () {
    return {
	  row: {
	  }
	}
  },
  components: {
    SweetModal
  },
  methods: {
    openModal (row) {
	  this.row = row
      this.$refs.viewModal.open()
    },
    closeModal () {
      this.$refs.viewModal.close()
    }
  }
}
</script>

</script>

<style scoped>
  .text-align-left {
	text-align: left;
  }
</style>

