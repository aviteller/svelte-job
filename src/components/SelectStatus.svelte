<script>
  import EasyHttp from "../easyhttp.js";
  export let status;
  export let id;

  let value = status;

  const changeStatus = e => {
    let newStatus = {
      id,
      field: {
        name : "status",
        value :  e.target.value,
      }
    };

    fetch("http://localhost/svelte-job/api/jobs/update.php", {
      credentials: "same-origin", // 'include', default: 'omit'
      method: "POST", // 'GET', 'PUT', 'DELETE', etc.
      body: JSON.stringify(newStatus), // Coordinate the body type with 'Content-Type'
      headers: new Headers({
        "Content-Type": "application/json"
      })
    }).then(response => response.json());

    // async () => {
    //   const res = await fetch(
    //     "http://localhost/svelte-job/api/jobs/update.php",
    //     {
    //       method: "PUT",
    //       headers: {
    //         "Content-type": "application/json"
    //       },
    //       body: JSON.stringify(newStatus)
    //     }
    //   );
    //   jobs = await res.json();
    // };
  };

  let statuses = [
    "New",
    "Recruiter",
    "First Call",
    "Phone Interview",
    "Meeting",
    "Interview"
  ];
</script>

<style>
  select {margin-bottom:10px;}
</style>

<select on:change={changeStatus} {value}>
  <option value="0" disabled>-- Please Select --</option>
  {#each statuses as stat}
    <option value={stat}>{stat}</option>
  {/each}
</select>
