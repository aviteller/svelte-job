<script>
  import SearchBox from "../components/SearchBox.svelte";

    import { createEventDispatcher } from "svelte";

  const dispatch = createEventDispatcher();

  const Search = (e) => {

    dispatch("search", e.detail);
  }

</script>

<div class="navbar bg-primary" style="text-align:center">
  <h1>Job Finder</h1>
  <div class="pull-right">
    <SearchBox on:search={Search}/>
  </div>
</div>
