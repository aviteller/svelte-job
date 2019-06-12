<script>
  //import SelectStatus from "./SelectStatus.svelte";
  import AddNote from "./AddNote.svelte";
  import Note from "./Note.svelte";
  import { createEventDispatcher } from "svelte";

  import { onMount } from "svelte";

 

  onMount(() => {
   addStars();
  });

  const dispatch = createEventDispatcher();
  export let name;
  export let description;
  export let status;
  export let id;
  export let rating;

  let notes = [];

  let editing = false;
  let showNoteForm = false;

  let statuses = [
    "New",
    "Recruiter",
    "First Call",
    "Phone Interview",
    "Meeting",
    "Interview"
  ];

  const updateField = e => {
    let newField = {
      id,
      field: {
        name: e.target.name,
        value: e.target.value
      }
    };

    fetch("http://localhost/svelte-job/api/jobs/update.php", {
      credentials: "same-origin", // 'include', default: 'omit'
      method: "POST", // 'GET', 'PUT', 'DELETE', etc.
      body: JSON.stringify(newField), // Coordinate the body type with 'Content-Type'
      headers: new Headers({
        "Content-Type": "application/json"
      })
    }).then(
      response => response.json(),
      e.target.name === "rating" ? addStars() : ""
    );
  };

  const changeFields = () => {
    editing = !editing;
  };

  const noteAddForm = async () => {
    const res = await fetch(
      "http://localhost/svelte-job/api/notes/read.php?id=" + id
    );
    notes = await res.json();

    if (notes.message) {
      notes = [];
    }

    showNoteForm = !showNoteForm;
  };

  const removeJob = e => {
    if (confirm("Are you sure ?")) {
      e.target.name = "deleted";
      e.target.value = 1;
      updateField(e);
      dispatch("removejob", id);
    }
  };

  const removeNote = e => {
    notes = notes.filter(note => note.id !== e.detail);
  };

  const noteAdded = e => {
    const newNote = e.detail;

    if (e.detail.message) {
      notes = [];
    } else {
      notes = [...notes, newNote];
    }
  };

  const addStars = e => {
    let starArray = [];
    for (let index = 1; index <= rating; index++) {
      starArray.push('<span class="fas fa-star"></span>');
    }

    for (let index = starArray.length; index < 5; index++) {
      starArray.push('<span class="far fa-star"></span>');
    }
    document.querySelectorAll(".starBox").forEach(el => {
      if (el.id == id) {
        el.innerHTML = starArray.join("");
      }
    });

  };

</script>

<style>
  textarea {
    margin-bottom: 10px;
  }
  select {
    margin-bottom: 10px;
  }
</style>

<div class="card">
  {#if !editing}
    <h1>
      <strong>Name:</strong>
       {name}
    </h1>
    <strong>Description:</strong>
    <pre>{description ? description : 'None'}</pre>
    <p>
      <strong>Status:</strong>
       {status}
    </p>
    <button on:click={changeFields} class="btn btn-sm">Edit</button>
    <button on:click={noteAddForm} class="btn btn-sm">{!showNoteForm ?'Show Notes':'Hide Notes'}</button>
    <button class="btn btn-danger btn-sm" on:click={removeJob}>x</button>
    {#if showNoteForm}
      <AddNote {id} on:noteadded={noteAdded} />
      {#if notes !== 0}
        {#each notes as note}
          <Note body={note.body} id={note.id} on:removenote={removeNote} />
        {/each}
      {:else}
        <p>Add more noted</p>
      {/if}
    {/if}
  {:else}
    <input type="text" name="name" bind:value={name} on:blur={updateField} />
    <textarea
      bind:value={description}
      name="description"
      on:blur={updateField} />

    <select on:change={updateField} {status} name="status" bind:value={status}>
      <option value="0" disabled>-- Please Select --</option>
      {#each statuses as stat}
        <option value={stat}>{stat}</option>
      {/each}
    </select>

    <select on:change={updateField} name="rating" bind:value={rating}>
      <option value="0" selected={rating===0}>0</option>
      <option value="1" selected={rating===1}>1</option>
      <option value="2" selected={rating===2}>2</option>
      <option value="3" selected={rating===3}>3</option>
      <option value="4" selected={rating===4}>4</option>
      <option value="5" selected={rating===5}>5</option>

    </select>
    <button on:click={changeFields} class="btn btn-sm">Save</button>
  {/if}

  <div class="starBox pull-right" {id}>show stars</div>

</div>
