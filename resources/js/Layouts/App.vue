
<template>
  <div>
    <header>
      <h1>App Header</h1>

    </header>
    <main>
      <slot></slot> 
    </main>
  </div>
</template>

<script>
export default {

};
</script>

<style scoped>
  header {
    background-color: #f4f4f4;
    padding: 20px;
    text-align: center;
  }
  main {
    padding: 20px;
  }
</style>
