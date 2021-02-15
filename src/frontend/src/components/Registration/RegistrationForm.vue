<template>
  <v-container>
    <v-stepper v-model="currentStep">
      <v-stepper-header>
        <div v-for="step in steps" :key="step.id">
          <v-stepper-step
              :complete="currentStep > step.id"
              :step="step.id"
          >
            {{ step.title }}
          </v-stepper-step>
        </div>
      </v-stepper-header>

      <v-stepper-items>
        <form>
          <first-step @prevStepClicked="handlePrevStep" @stepFormUpdated="handleFormData"/>
          <second-step @prevStepClicked="handlePrevStep" @stepFormUpdated="handleFormData"/>
          <third-step @prevStepClicked="handlePrevStep" @stepFormUpdated="handleFormData"/>
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
      currentStep: 1,
      steps: [
        {
          "id": 1,
          "title": "Personal Information"
        },
        {
          "id": 2,
          "title": "Address Information"
        },
        {
          "id": 3,
          "title": "Payment Information"
        }
      ],
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
      this.formData = {...this.formData, ...event}
      if (event.current_step !== this.stepsCount) {
        this.currentStep = event.current_step + 1;
      }

      if (event.current_step === this.stepsCount) {
        const registerReqBody = {...this.formData};
        registerUser(registerReqBody);
        console.log('asdfghj');
        localStorage.removeItem('formData');
        localStorage.removeItem('currentStep');
      }
    },
    handlePrevStep(currentStep) {
      console.log(currentStep);
      if (currentStep === 1) {
        return false
      }

      this.currentStep = currentStep - 1;
    }
  },
  computed: {
    stepsCount() {
      return this.steps.length;
    }
  },
  mounted() {
    if (localStorage.getItem('currentStep')) {
      this.currentStep = localStorage.currentStep;
      this.formData = {...JSON.parse(localStorage.getItem('formData'))}
    }
  },
  watch: {
    formData(newFormData) {
      if(localStorage.getItem('currentStep')) {
        localStorage.setItem('formData',JSON.stringify(newFormData));
        console.log('Attar');
      }
    },
    currentStep(newCurrentStep) {
      localStorage.setItem('currentStep', newCurrentStep);
    }
  }
}
</script>
