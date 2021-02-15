<template>
  <div>
    <p>{{ msg }}</p>
  </div>
</template>

<script>
export default {
  name: 'HelloThere',
  props: {
      msg: String
  }
}
</script>

<style>
p {
  font-family: "Arial", sans-serif;
  font-size: 90px;
  text-align: center;
  font-weight: bold;
}
</style>
