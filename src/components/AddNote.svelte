<script>
  export let id;

  import { createEventDispatcher } from "svelte";

  const dispatch = createEventDispatcher();

  let note = {
    jobid: id,
    body: ""
  };

  async function createNote(note) {
    let res = await fetch("http://localhost/svelte-job/api/notes/create.php", {
      method: "POST", // 'GET', 'PUT', 'DELETE', etc.
      body: JSON.stringify(note), // Coordinate the body type with 'Content-Type'
      headers: new Headers({
        "Content-Type": "application/json"
      })
    });
    let data = await res.json();
    return data;
  }

  const addNote = e => {
    e.preventDefault();
    if (note.body) {
      createNote(note).then(data => {
        (note = {
          id: data.id,
          jobid: data.jobid,
          body: data.body
        }),
          dispatch("noteadded", note);
        note = {
          jobid: id,
          body: ""
        };
      });
    }
  };
</script>

<style>
  textarea {
    margin-bottom: 10px;
  }
</style>

<form class="grid-1" {id} on:submit={addNote}>
  <div class="form-group">

    <textarea bind:value={note.body} placeholder="Note Body" />

    <input type="submit" value="Add Note" class="btn btn-primary btn-block" />
  </div>
</form>
