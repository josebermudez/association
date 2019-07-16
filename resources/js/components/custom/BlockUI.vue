<template>
	<BlockUI v-if="loading">
		<slot-spinner/>
    </BlockUI>
</template>


<script type="text/babel">
import BlockUI from 'vue-blockui'
import SlotSpinner from './slots/SlotSpinner'

export default {
  components: {
    SlotSpinner
  },
  data () {
    return {
	  msg: this.$t('general.labels.loading'),
	  loading: false
    }
  }
}

</script>


