<template>
  <v-app>
    <v-app-bar
      app
      color="primary"
      dark
    >
      <v-toolbar-title>Wunder Mobility</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <RegistrationForm></RegistrationForm>
    </v-main>
  </v-app>
</template>

<script>
import RegistrationForm from "@/components/Registration/RegistrationForm";

export default {
  name: 'App',
  components: {
    RegistrationForm,
  },
};
</script>
