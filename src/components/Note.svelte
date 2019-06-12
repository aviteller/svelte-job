<script>

  import { createEventDispatcher } from "svelte";

  const dispatch = createEventDispatcher();
  export let body;
  export let id;
    const updateField = e => {
    let newField = {
      id,
      field: {
        name: e.target.name,
        value: e.target.value
      }
    };

    fetch("http://localhost/svelte-job/api/notes/update.php", {
      credentials: "same-origin", // 'include', default: 'omit'
      method: "POST", // 'GET', 'PUT', 'DELETE', etc.
      body: JSON.stringify(newField), // Coordinate the body type with 'Content-Type'
      headers: new Headers({
        "Content-Type": "application/json"
      })
    }).then(response => response.json());
  };

    const removeNote = e => {

    if(confirm("Are you sure ?")) {
      e.target.name = "deleted";
      e.target.value = 1;
      updateField(e);
      dispatch("removenote", id);
    }
  };

</script>

<div>
  <p>Note #{id} <button class="btn btn-danger btn-sm pull-right" on:click={removeNote}>x</button></p>
  <pre>{body}</pre>
  <hr />
</div>
