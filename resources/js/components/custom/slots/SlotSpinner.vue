<template>
<div class="container">
	<slot>
		<pacman-loader class="custom-class" :color="color" :size="size" :sizeUnit="sizeUnit"></pacman-loader>
	</slot>
</div>
</template>

<script type="text/babel">
import { PacmanLoader } from '@saeris/vue-spinners'

export default {
  data () {
    return {
	  sizeUnit: "px",
	  color: "#bada55",
	  size: 30,
	  loading: false
    }
  }
}

</script>

<style scoped>
  .container {
	width:150px;
    height: 40px;
  }
</style>
