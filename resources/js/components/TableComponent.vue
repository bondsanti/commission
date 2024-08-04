<template>
  <table class="table table-bordered">
    <thead>
      <tr class="text-center">
        <th width="1%">No.</th>
        <th width="1%">Code</th>
        <th width="50%" class="text-left">Sale Name</th>
        <th width="10%">Potision</th>
        <th width="1%">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{test}}</td>
        <td>s</td>
        <td>s</td>
        <td>s</td>
        <td>s</td>
      </tr>
    </tbody>
  </table>
</template>
<script>
export default {
  props: ["items"],
  data: {
    test: "sss"
  }
  //   mounted() {
  //     console.log("item ", items);
  //   },
  //   data: {},
  //   created: function() {
  //     console.log("a is: " + this.items);
  //   }
};
</script>
