<script>
  import { createEventDispatcher } from "svelte";

  const dispatch = createEventDispatcher();

  let job = {
    name: "",
    description: ""
  };

  async function createJob(job) {
    let res = await fetch("http://localhost/svelte-job/api/jobs/create.php", {
      method: "POST", // 'GET', 'PUT', 'DELETE', etc.
      body: JSON.stringify(job), // Coordinate the body type with 'Content-Type'
      headers: new Headers({
        "Content-Type": "application/json"
      })
    });
    let data = await res.json();
    return data;
  }

  const onSubmit = e => {
    e.preventDefault();
    if(job.name != "") {

      createJob(job).then(data => {
        (job = {
          id: data.id,
          status: data.status,
          name: data.name,
          description: data.description
        }),
          dispatch("addjob", job);
        job = {
          name: "",
          description: ""
        };
      });
    }
  };
</script>

<form class="grid-1" on:submit={onSubmit}>
  <input type="text" placeholder="Job Name" bind:value={job.name} />
  <textarea bind:value={job.description} placeholder="Job Desc" />

  <input type="submit" value="Add Job" class="btn btn-primary btn-block" />
</form>
