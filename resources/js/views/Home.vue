<script setup>
import axios from "axios"
import { VBtn } from "vuetify/components"
import { VContainer, VRow, VCol, VProgressLinear } from "vuetify/components"
import {onBeforeMount, ref} from "vue"
import Echo from "laravel-echo"

let echo = null
let channel = null

const loading = ref(false)
const disableStart = ref(false)
const fileUrl = ref(null)
const showProgressBar = ref(false)
const progress = ref(0)

const initSocket = () => {
	if (!echo) {
		echo = new Echo({
			authEndpoint: '/broadcasting/auth',
			auth: {
				headers: {
					'Authorization': `Bearer ${localStorage.getItem('token')}`,
					'Accept': 'application/json'
				}
			},
			broadcaster: 'pusher',
			key: import.meta.env.VITE_PUSHER_APP_KEY,
			wsHost: import.meta.env.VITE_PUSHER_HOST,
			wsPort: import.meta.env.VITE_PUSHER_PORT,
			forceTLS: false
		})

		channel = echo
			.private('lw.' + JSON.parse(localStorage.getItem('user')).id)
			.listen('.file-updated-event', (data) => {
				if (showProgressBar.value === false) {
					showProgressBar.value = true
				}

				if (disableStart.value === false) {
					disableStart.value = true
				}

				progress.value = Math.ceil((data.file.generated / data.file.total) * 100)
				if (data.file.url) {
					fileUrl.value = data.file.url
					disableStart.value = false
				}
			})
	}
}

const start = () => {
	const token = localStorage.getItem('token')

	loading.value = true
	axios
		.post('/api/files', {}, {
			headers: {
				'Authorization': `Bearer ${token}`,
			}
		})
		.then(response => {
			loading.value = false
			showProgressBar.value = true
			disableStart.value = true
		})
		.catch(error => {
			loading.value = false
			console.error(error)
		})
}

const reset = () => {
	fileUrl.value = null
}

onBeforeMount(() => {
	initSocket()
})

</script>

<template>
    <h1 class="text-center">Random file generator</h1>
    <v-container class="mt-5">
        <v-row>
            <v-col class="text-center">
                <v-btn
                    @click="start"
                    color="primary"
                    :loading="loading"
                    :disabled="disableStart"
                >
                    Start
                </v-btn>
            </v-col>
        </v-row>

        <v-row v-if="showProgressBar">
            <v-col>
                <v-progress-linear
                    v-model="progress"
                    color="green"
                    height="25"
                >
	                <strong>{{ progress }}%</strong>
                </v-progress-linear>
            </v-col>
        </v-row>

	    <v-row v-if="fileUrl">
		    <v-col cols="12">
			    <a :href="fileUrl" target="_blank">Download File</a>
		    </v-col>
	    </v-row>
    </v-container>
</template>

<style scoped>

</style>
