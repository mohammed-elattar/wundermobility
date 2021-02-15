<template>
  <v-stepper-content step="2">
    <v-text-field
        v-model="street"
        :counter="10"
        :error-messages="streetErrors"
        label="street"
        required
        @blur="$v.street.$touch()"
        @input="$v.street.$touch()"
    ></v-text-field>
    <v-text-field
        v-model="houseNumber"
        :counter="10"
        :error-messages="houseNumberErrors"
        label="House Number"
        required
        @blur="$v.houseNumber.$touch()"
        @input="$v.houseNumber.$touch()"
    ></v-text-field>
    <v-text-field
        v-model="zipCode"
        :counter="10"
        :error-messages="zipCodeErrors"
        label="zipCode"
        required
        @blur="$v.zipCode.$touch()"
        @input="$v.zipCode.$touch()"
    ></v-text-field>
    <v-text-field
        v-model="city"
        :counter="10"
        :error-messages="cityErrors"
        label="city"
        required
        @blur="$v.city.$touch()"
        @input="$v.city.$touch()"
    ></v-text-field>

    <v-btn
        class="mr-4"
        @click="prevStep"
    >
      prev
    </v-btn>
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
  name: 'SecondStep',
  mixins: [validationMixin],
  validations: {
    street: {required},
    houseNumber: {required},
    zipCode: {required},
    city: {required},
  },
  data: () => ({
    street: '',
    houseNumber: '',
    zipCode: '',
    city: '',
    currentStep: 2
  }),
  computed: {
    streetErrors() {
      const errors = []
      if (!this.$v.street.$dirty) return errors
      !this.$v.street.required && errors.push('Street is required.')
      return errors
    },
    houseNumberErrors() {
      const errors = []
      if (!this.$v.houseNumber.$dirty) return errors
      !this.$v.houseNumber.required && errors.push('House Number is required.')
      return errors
    },
    zipCodeErrors() {
      const errors = []
      if (!this.$v.zipCode.$dirty) return errors
      !this.$v.zipCode.required && errors.push('Zipcode is required.')
      return errors
    },
    cityErrors() {
      const errors = []
      if (!this.$v.city.$dirty) return errors
      !this.$v.city.required && errors.push('city is required.')
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
          "address":
              {
                "street": this.street,
                "house_number": this.houseNumber,
                "zip_code": this.zipCode,
                "city": this.city,
              },
          "current_step": this.currentStep
        }
        this.$emit('stepFormUpdated', formData);
      }
    },
    prevStep() {
      this.$emit('prevStepClicked', this.currentStep);
    },
    clear() {
      this.$v.$reset()
      this.street = ''
      this.houseNumber = ''
      this.zipCode = ''
      this.city = ''
    },
  },
  mounted() {
    if (localStorage.getItem('currentStep')) {
      const allFormData = {...JSON.parse(localStorage.getItem('formData'))};
      const {street, house_number, zip_code, city} = allFormData.address;
      this.street = street
      this.houseNumber = house_number
      this.zipCode = zip_code
      this.city = city
    }
  },
}
</script>
