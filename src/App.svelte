<script>
  import Navbar from "./layout/Navbar.svelte";
  import Job from "./components/Job.svelte";
  //import SelectStatus from "./components/SelectStatus.svelte";
  import CreateJob from "./components/CreateJob.svelte";

  import { onMount } from "svelte";

  let jobs = [];

  onMount(async () => {
    const res = await fetch("http://localhost/svelte-job/api/jobs/read.php");
    jobs = await res.json();

    if (jobs.message) {
      jobs = [];
    }
  });

  const addJob = e => {
    const newJob = e.detail;

    jobs = [...jobs, newJob];
  };

  const removeJob = e => {
    jobs = jobs.filter(job => job.id !== e.detail);
  };

  const Search = e => {
    if (e.detail.message) {
      jobs = [];
      let msgBox = document.querySelector("#noJobsMsg");
      if (msgBox) {
        msgBox.innerHTML = e.detail.message;
      }
    } else {
      jobs = e.detail;
    }
  };
</script>

<style>

</style>

<Navbar on:search={Search} />
<div class="container">
  <CreateJob on:addjob={addJob} />

  {#if jobs.length === 0}
    <p id="noJobsMsg">No Jobs Found</p>
  {:else}
    {#each jobs as job}
      <Job
        name={job.name}
        description={job.description}
        status={job.status}
        id={job.id}
        rating={job.rating}
        on:removejob={removeJob} />
    {/each}
  {/if}
</div>
