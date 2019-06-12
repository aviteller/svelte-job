<script>
  let name = "";
  let jobs = [];

  import { createEventDispatcher } from "svelte";

  const dispatch = createEventDispatcher();

  const getSearchResults = async () => {
      let url = new URL("http://localhost/svelte-job/api/jobs/read.php");
    let params = { search: name };

    url.search = new URLSearchParams(params)
        let res = await fetch(url);
      let data = await res.json();
      return data;
  }

  const clear = () => {
    name = "";
    getSearchResults().then(jobs => dispatch("search", jobs))
  }

  const onSubmit = e => {
  

    getSearchResults().then(jobs => dispatch("search", jobs))
  
    e.preventDefault();
  };
</script>

<form on:submit={onSubmit}>
<div class="form-group" >
  <input style="float:left" type="text" placeholder="Job Name" bind:value={name} />
  <button on:click={clear} class="btn btn-danger btn-sm">x</button>
  <input type="submit" value="Search" class="btn btn-success btn-sm" />
</div>

</form>
