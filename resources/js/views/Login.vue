<script setup>
import { VBtn } from "vuetify/components"
import { VTextField, VForm, VSheet } from "vuetify/components"
import {onBeforeMount, ref} from "vue"
import axios from "axios"
import {useRouter} from "vue-router"

const router = useRouter()

const form = ref(null)
const email = ref(null)
const password = ref(null)

const loading = ref(false)

const submit = () => {
	if (form.value.validate()) {
		loading.value = true
		axios
			.post('/api/auth/login', {
				email: email.value,
				password: password.value
			})
			.then(response => {
				loading.value = false
				const token = response.data.token
				localStorage.setItem('token', token)
				localStorage.setItem('user', JSON.stringify(response.data.user))

				router.push({path: '/'})
			})
			.catch(error => {
				loading.value = false
			})
	}
}

</script>

<template>
    <h1 class="text-center">Login</h1>
    <v-sheet class="mx-auto mt-15" width="300">
        <v-form ref="form">
            <v-text-field
                v-model="email"
                label="Email Address"
                required
            />

            <v-text-field
                v-model="password"
                type="password"
                label="Password"
                required
            />

            <div class="d-flex flex-column">
                <v-btn
                    class="mt-4"
                    color="success"
                    :loading="loading"
                    block
                    @click="submit"
                >
                    Submit
                </v-btn>
            </div>
        </v-form>
    </v-sheet>
</template>

<style scoped>

</style>
