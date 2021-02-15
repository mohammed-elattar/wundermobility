<template>
  <v-stepper-content step="1">
    <v-text-field
        v-model="firstName"
        :counter="10"
        :error-messages="firstNameErrors"
        label="First Name"
        required
        @blur="$v.firstName.$touch()"
        @input="$v.firstName.$touch()"
    ></v-text-field>
    <v-text-field
        v-model="lastName"
        :counter="10"
        :error-messages="lastNameErrors"
        label="Last Name"
        required
        @blur="$v.lastName.$touch()"
        @input="$v.lastName.$touch()"
    ></v-text-field>
    <v-text-field
        v-model="telephone"
        :counter="10"
        :error-messages="telephoneErrors"
        label="Telephone"
        required
        @blur="$v.telephone.$touch()"
        @input="$v.telephone.$touch()"
    ></v-text-field>
    <v-text-field
        v-model="password"
        :counter="10"
        :error-messages="passwordErrors"
        label="Password"
        required
        @blur="$v.password.$touch()"
        @input="$v.password.$touch()"
    ></v-text-field>

    <v-btn
        class="mr-4"
        @click="submit"
    >
      next
    </v-btn>
    <v-btn @click="clear">
      clear
    </v-btn>
  </v-stepper-content>
</template>

<script>
import {validationMixin} from 'vuelidate'
import {required} from 'vuelidate/lib/validators'

export default {
  name: 'FirstStep',
  mixins: [validationMixin],
  validations: {
    firstName: {required},
    lastName: {required},
    telephone: {required},
    password: {required},
  },
  data: () => ({
    firstName: '',
    lastName: '',
    telephone: '',
    password: '',
    currentStep: 1,
  }),
  computed: {
    firstNameErrors() {
      const errors = []
      if (!this.$v.firstName.$dirty) return errors
      !this.$v.firstName.required && errors.push('First Name is required.')
      return errors
    },
    lastNameErrors() {
      const errors = []
      if (!this.$v.lastName.$dirty) return errors
      !this.$v.lastName.required && errors.push('Last Name is required.')
      return errors
    },
    telephoneErrors() {
      const errors = []
      if (!this.$v.telephone.$dirty) return errors
      !this.$v.telephone.required && errors.push('Telephone is required.')
      return errors
    },
    passwordErrors() {
      const errors = []
      if (!this.$v.password.$dirty) return errors
      !this.$v.password.required && errors.push('Password is required.')
      return errors
    },

  },
  methods: {
    submit() {
      this.$v.$touch()
      if (this.$v.$invalid) {
        return false;
      } else {
        const formData = {
          "first_name": this.firstName,
          "last_name": this.lastName,
          "telephone": this.telephone,
          "password": this.password,
          "current_step": this.currentStep
        }
        this.$emit('stepFormUpdated', formData);
        this.$emit('stepFormUpdated', formData);
      }
    },
    clear() {
      this.$v.$reset()
      this.firstName = ''
      this.lastName = ''
      this.telephone = ''
      this.password = ''
    },
  },
  mounted() {
    if (localStorage.getItem('currentStep')) {
      const allFormData = {...JSON.parse(localStorage.getItem('formData'))};
      const {first_name, last_name, telephone, password} = allFormData;
      this.firstName = first_name
      this.lastName = last_name
      this.telephone = telephone
      this.password = password
    }
  },
}
</script>


<!--firstName: {-->
<!--get() {-->
<!--return this.$store.state.first_name;-->
<!--},-->
<!--set(value) {-->
<!--return this.$store.commit('setFirstName', {'firstName': value});-->
<!--},-->
<!--},-->
<!--lastName: {-->
<!--get() {-->
<!--return this.$store.state.last_name;-->
<!--},-->
<!--set(value) {-->
<!--return this.$store.commit('setLastName', {'lastName': value});-->
<!--},-->
<!--},-->
<!--telephone: {-->
<!--get() {-->
<!--return this.$store.state.telephone;-->
<!--},-->
<!--set(value) {-->
<!--return this.$store.commit('setTelephone', {'telephone': value});-->
<!--},-->
<!--},-->
<!--password: {-->
<!--get() {-->
<!--return this.$store.state.password;-->
<!--},-->
<!--set(value) {-->
<!--return this.$store.commit('setPassword', {'password': value});-->
<!--},-->
<!--}-->
