<script>
  import Navbar from "./layout/Navbar.svelte";
  import Job from "./components/Job.svelte";
  //import SelectStatus from "./components/SelectStatus.svelte";
  import CreateJob from "./components/CreateJob.svelte";

  import { onMount } from "svelte";

  let jobs = [];
  let deleted = false;

  onMount(() => {
    getJobs(false);
  });

  const getJobs = async (deleted = false, orderBy=null) => {
    let res = '';

    if(deleted){
      res = await fetch(`http://localhost/svelte-job/api/jobs/read.php?deleted=1${orderBy?'&orderBy='+orderBy:''}`);
    } else {
       res = await fetch(`http://localhost/svelte-job/api/jobs/read.php${orderBy?'?orderBy='+orderBy:''}`);
    }
    jobs = await res.json();

    if (jobs.message) {
      jobs = [];
    }
  };

  const getDeleted = () => {
    deleted = !deleted;
    getJobs(true);
  };
  const getLive= () => {
    deleted = !deleted;
    getJobs();
  };

  const addJob = e => {
    const newJob = e.detail;
    jobs = [newJob, ...jobs];
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

  const getByRating = () => {
    getJobs(false, 'rating');
  }
</script>

<style>

</style>

<Navbar on:search={Search} />
<div class="container">
  <div>
    {#if !deleted}
      <button class="btn btn-danger" on:click={getDeleted}>Deleted</button>
       <button class="btn btn-info" on:click={getByRating}>Sort by rating</button>
    {:else}
      <button class="btn btn-success" on:click={getLive}>Return</button>
      <button class="btn btn-info" on:click={getByRating}>Sort by rating</button>
    {/if}
  </div>
  <CreateJob on:addjob={addJob} />

  {#if jobs.length === 0}
    <p id="noJobsMsg">No Jobs Found</p>
  {:else}
    <p>No of jobs {jobs.length}</p>
    {#each jobs as job}
      <Job
        name={job.name}
        description={job.description}
        status={job.status}
        id={job.id}
        rating={job.rating}
        createddatetime={job.createddatetime}
        distance={job.distance}
        wage={job.wage}
        company={job.company}
        link={job.link}
        on:removejob={removeJob} />
    {/each}
  {/if}
</div>
