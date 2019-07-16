// Filters.js
import Vue from 'vue';
import moment from 'moment'

/**
 * formatDate: It format a date into the required format.
 * @param {string} value
 * @returns {string} value
 */
Vue.filter("formatDate", (value, customFormat) => {
	var format = customFormat ? customFormat : 'DD/MM/YYYY hh:mm A';
	if (value) {
		return moment(String(value)).format(format)
	}
	return 'asdasd';
});