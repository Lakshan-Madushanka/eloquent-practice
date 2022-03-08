<template>
  <h1>Job Report</h1>

  <h2 v-if="loading">Loading ...</h2>
  <table v-else id="customers">
    <tr>
      <th>Month</th>

      <th v-for="jobCode in jobCodes" :key="jobCode">
        Job Amount {{ jobCode }}
      </th>
      <th v-for="jobCode in jobCodes" :key="jobCode">
        Job count {{ jobCode }}
      </th>
    </tr>
    <tr v-for="(date, name) in report" :key="name">
      <td>{{ name }}</td>

      <template v-for="jobCode in jobCodes" :key="jobCode">
        <td>{{ date[jobCode] ? date[jobCode]["amount"] : 0 }}</td>
        <td>{{ date[jobCode] ? date[jobCode]["count"] : 0 }}</td>
      </template>
    </tr>
  </table>
</template>

<script>
import { ref } from "vue";
export default {
  setup() {
    const jobCodes = ref([]);
    const report = ref({});
    const loading = ref(false);

    (async () => {
      loading.value = true;
      const response = await fetch("http://localhost:821/api/jobs/analysis");
      const results = await response.json();

      jobCodes.value = results.jobCodes;
      report.value = results.jobsArray;
      console.log(results, "hello");
      loading.value = false;
    })();

    return { jobCodes, report, loading };
  },
};
</script>
<style scoped>
.customers,
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 50%;
  margin: auto;
}

#customers td,
#customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even) {
  background-color: #f2f2f2;
}

#customers tr:hover {
  background-color: #ddd;
}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04aa6d;
  color: white;
}
</style>
