<template>
  <v-stepper-content step="3">
    <v-text-field
        v-model="accountOwner"
        :counter="10"
        :error-messages="accountOwnerErrors"
        label="Account Owner"
        required
        @blur="$v.accountOwner.$touch()"
        @input="$v.accountOwner.$touch()"
    ></v-text-field>
    <v-text-field
        v-model="iban"
        :counter="10"
        :error-messages="ibanErrors"
        label="Iban"
        required
        @blur="$v.iban.$touch()"
        @input="$v.iban.$touch()"
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
      submit
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
  name: 'ThirdStep',
  mixins: [validationMixin],
  validations: {
    accountOwner: {required},
    iban: {required},
  },
  data: () => ({
    accountOwner: '',
    iban: '',
    currentStep: 3
  }),
  computed: {
    accountOwnerErrors() {
      const errors = []
      if (!this.$v.accountOwner.$dirty) return errors
      !this.$v.accountOwner.required && errors.push('Account is required.')
      return errors
    },
    ibanErrors() {
      const errors = []
      if (!this.$v.iban.$dirty) return errors
      !this.$v.iban.required && errors.push('Iban is required.')
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
          "payment_infos":
              {
                "account_owner": this.accountOwner,
                "iban": this.iban,
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
      this.accountOwner = ''
      this.iban = ''
    },
  },
  mounted() {
    if (localStorage.getItem('currentStep')) {
      const allFormData = {...JSON.parse(localStorage.getItem('formData'))};
      const {account_owner, iban} = allFormData.payment_infos;
      this.accountOwner = account_owner
      this.iban = iban
    }
  },
}
</script>
