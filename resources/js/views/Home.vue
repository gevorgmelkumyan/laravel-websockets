<script setup>
import axios from "axios"
import { VBtn } from "vuetify/components"
import { VContainer, VRow, VCol, VFileInput, VTable, VChip, VSkeletonLoader } from "vuetify/components"
import {onBeforeMount, ref} from "vue"

const loading = ref(false)
const fileUrl = ref(null)
const progress = ref(0)

const start = () => {
	loading.value = true
	axios
		.post('/api/files')
		.then(response => {
			loading.value = false
			uploadedFiles.value = response.data
		})
		.catch(error => {
			loading.value = false
			console.error(error)
		})
}

const reset = () => {
	fileUrl.value = null
}

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
                >
                    Start
                </v-btn>
            </v-col>
        </v-row>

        <v-row>
            <v-col>
                <v-progress-linear
                    v-model="progress"
                    color="green"
                    height="25"
                >
                    <template v-slot:default="{ value }">
                        <strong>{{ Math.ceil(value) }}%</strong>
                    </template>
                </v-progress-linear>
            </v-col>
        </v-row>

	    <v-row v-if="fileUrl">
		    <v-col cols="12">
			    <p class="mt-4">File URL: {{ fileUrl }}</p>
		    </v-col>
	    </v-row>
    </v-container>
</template>

<style scoped>

</style>
