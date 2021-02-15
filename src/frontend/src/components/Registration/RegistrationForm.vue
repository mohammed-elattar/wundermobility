<template>
  <v-container>
  <v-stepper v-model="e1">
    <v-stepper-header>
      <v-stepper-step
          :complete="e1 > 1"
          step="1"
      >
        Personal Information
      </v-stepper-step>

      <v-divider></v-divider>

      <v-stepper-step
          :complete="e1 > 2"
          step="2"
      >
        Address Info
      </v-stepper-step>

      <v-divider></v-divider>

      <v-stepper-step step="3">
        Payment Info
      </v-stepper-step>
    </v-stepper-header>

    <v-stepper-items>
      <form>
        <first-step @stepFormUpdated="handleFormData"/>
        <second-step @stepFormUpdated="handleFormData"/>
        <third-step @stepFormUpdated="handleFormData"/>
      </form>
    </v-stepper-items>
  </v-stepper>
  </v-container>
</template>

<script>
import FirstStep from "@/components/Registration/FirstStep";
import SecondStep from "@/components/Registration/SecondStep";
import ThirdStep from "@/components/Registration/ThirdStep";
import {registerUser} from "../../../servics/users";

export default {
  components: {ThirdStep, SecondStep, FirstStep},
  data() {
    return {
      e1: 1,
      formData: {
        "first_name": "",
        "last_name": "",
        "telephone": "",
        "password": "",
        "address": {
          "street": "",
          "house_number": "",
          "zip_code": "",
          "city": ""
        },
        "payment_infos": {
          "account_owner": "",
          "iban": ""
        }
      }
    }
  },
  methods: {
    handleFormData(event) {
      this.formData = { ...this.formData, ...event}
      //TODO to be changed to be length of the array
      if(event.current_step !== 3) {
        this.e1 = event.current_step +1;
      }

      if(event.current_step === 3) {
        const registerReqBody = {...this.formData};
        delete  registerReqBody.current_step;
        registerUser(registerReqBody);
      }
    }
  }
}
</script>
