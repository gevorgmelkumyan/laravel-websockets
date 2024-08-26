<script setup>
import { VBtn } from "vuetify/components"
import { VTextField, VForm, VSheet } from "vuetify/components"
import {onBeforeMount, ref} from "vue"

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
