<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
?>

<h1 class="entry-title">Søg projekter</h1>

<nav id="filtrering">
 <div class="dropdown_projekt">
  <button onclick="myFunction()" class="dropbtn">Vælg Verdensmål</button>
  <div id="myDropdown" class="dropdown-content">
    <button data-projekt="alle">Alle</button>
  </div>
</div> 
</nav>

 <section id="popup">
           <div id="luk">&#x2715 </div>
      <article>
        <img src="" alt="" class="billede" />
        <div>
          <p class="verdensmaal">Fokus:</p>
          <p class="uddannelsestrin">Udannelsestrin:</p>
          <p class="skolenavn">Skolenavn:</p>
          <p class="kontakt">Kontakt:</p>
        </div>
        <h2 class="projekt_titel"></h2>
        <p class="teaser_tekst"></p>
        <p class="projekt_beskriv"></p>
        <p class="til_laererne"></p>
        <p class="til_elever"></p>
      </article>
    </section>

<template class="loopview">
          <article>
            <div class="img_box">
            <img src="" alt="" class="billede" />
            </div>
            <h2 class="projekt_titel"></h2>
            <p class="teaser_tekst"></p>
            <p class="verdensmaal"></p>
          </article>
      </template>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		</main><!-- #main -->
		<style>



.dropbtn {
	width: 250px;
	display: grid;
	place-self: center;
  margin-bottom: 5px;
}

.dropdown_projekt {
  position: relative;
  /* display: inline-block; */
  display: grid;
}

.dropdown-content {
  display: none;
  /* position: absolute; */
  /* background-color: #f6f6f6; */
  min-width: 230px;
  /* border: 1px solid #ddd; */
  /* z-index: 1; */
  height: 400px;
  overflow: auto;
}

.show {
  display: grid;
  gap: 5px;
}


.page .entry-title, .page-title {
	margin-top: 45px;
	color: #222;
	font-size: 26px;
	font-size: 1.625rem;
	font-weight: 700;
	text-align: center;
	font-family: Montserrat,sans-serif;
	text-transform: uppercase;
}

#filtrering{
	display: flex;
justify-content: center;
margin-bottom: 50px;
}


.projekt_titel {
  color: #0bb4aa;
}

.teaser_tekst,
.verdensmaal {
  color: #777;
}



  article {
     padding: 10px;
    cursor: pointer;
    place-content: center;
	background-color: #f5f5f5;
  }

  /* article:hover {
    box-shadow: 5px 5px #147ca6;
  } */

  main {
    max-width: 1000px;
    /* margin: auto 20px auto 20px; */
  }

   main {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 5px;
    margin: 0 auto;

}

  #popup {
    display: none;
    position: fixed;
    left: 0;
    top: 0;
    width: 100vw;
    background-color: rgba(0, 0, 0, 0.8);
    overflow: auto;
  }

  #popup article {
      width: 70vw;
      height: 500px;
      margin: 12rem auto;
      border-radius: 25px;
      padding: 12px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-rows: 200px 100px;
      gap: 20px;
    }
  }

  #popup article h2 {
    margin: 10px 0px 70px 0px;
    grid-column: 2/3;
    grid-row: 1/2;
    place-self: start;
    /* color: #f2f2f2; */
  }

  #popup article img {
    border-radius: 8px;
    place-self: center;
    grid-column: 1/2;
    grid-row: 1/3;
    max-height: 100%;
    max-width: 50%;
  }

  #luk {
    position: fixed;
padding: 6.25em 0 0 7.5em;
font-size: 2em;
font-weight: bolder;
color: black;
cursor: pointer;
  }

  #luk:hover {
    color: #032f40;
  }

  .langtekst{
	  font-size: 0.8rem;
  }

.img_box{
  padding: 0;
}

		</style>
<script>
	// Tjekker om DOM'en er loaded før siden vises
window.addEventListener("DOMContentLoaded", start);
function start() {
  console.log("start");

  // Definerer stien til json-array fra restdb i stedet for lokal .json-fil
  // Henter 2 collections fra samme database
  const url = "http://hoffmannlund.dk/kea/09_CMS/unesco-asp/wp-json/wp/v2/projekt?per_page=100";
  const catUrl = "http://hoffmannlund.dk/kea/09_CMS/unesco-asp/wp-json/wp/v2/categories?per_page=100";
//   const url2 = "https://passion-410f.restdb.io/rest/omos";

  
  // definere globale variable
  const main = document.querySelector("main");
  const section = document.querySelector(".infoBoks");
  const template = document.querySelector(".loopview").content;
//   const template2 = document.querySelector(".bloggerBoks").content;
  const popup = document.querySelector("#popup");
  const article = document.querySelector("article");
  const lukKnap = document.querySelector("#luk");
  const header = document.querySelector("h1");

  let projekter;
  let filter = "alle";
  let categories;

  // Henter json-data fra restdb via fetch() fra to forskellige collections i samme database
  async function hentData() {
    const respons = await fetch(url);
	const catData = await fetch(catUrl);
    // const respons2 = await fetch(url2, options);
    projekter = await respons.json();
	categories = await catData.json();
    // bloggere = await respons2.json();
    console.log("Projekter", projekter);
	console.log("Kategorier", categories);
    // console.log("Bloggere", bloggere);
    visProjekter();
	opretKnapper();
    // visBloggere();
  }

  function opretKnapper(){
	  console.log("opretKnapper");

	  categories.forEach(cat => {
		  document.querySelector("#myDropdown").innerHTML +=`<button class="filter" data-projekt="${cat.id}">${cat.name}</button>`
	  })
	  addEventListenersToButtons();
  }

  function addEventListenersToButtons(){
			document.querySelectorAll("#myDropdown button").forEach(elm =>{
				elm.addEventListener("click", filtrering);
			})
		};

		function filtrering(){
			filter = this.dataset.projekt;
			console.log(filter);
			visProjekter();
		}

  // loop'er gennem alle artister i json-arrayet
  function visProjekter() {
    console.log("visProjekter");

    main.textContent = ""; // Her resetter jeg DOM'en ved at tilføje en tom string

    // for hver artist i arrayet, skal der tjekkes om de opfylder filter-kravet og derefter vises i DOM'en.
    projekter.forEach((projekt) => {
      if (filter == "alle" || projekt.categories.includes(parseInt(filter))) {
        const klon = template.cloneNode(true);
        klon.querySelector(".billede").src = projekt.billede.guid;
        klon.querySelector(".projekt_titel").textContent = projekt.title.rendered;
        klon.querySelector(".teaser_tekst").textContent = projekt.teaser_tekst;
        klon.querySelector(".verdensmaal").textContent = projekt.verdensmaal;
        // tilføjer eventlistner til hvert article-element og lytter efter klik på artiklerne. Funktionen "visDetaljer" bliver kaldt ved klik.
        klon
          .querySelector("article")
          .addEventListener("click", () => {location.href = projekt.link});

        // tilføjer klon-template-elementet til main-elementet (så det hele vises i DOM'en)
        main.appendChild(klon);
      }
    });
  }

  // tilføjer objekter fra arrayet (for hver artist) til popup-vindue. Samt sætter cursor til default, så man ikke tror man kan klikke på elementet igen.
  function visDetaljer(projekt) {
    console.log(projekt);
    // document.querySelector(".nav").style.position = "inherit";
    article.style.cursor = "default";
    popup.style.display = "block";
    popup.querySelector(".billede").src = projekt.billede.guid;
    popup.querySelector(".billede").style.maxWidth = "50%";
    // popup.querySelector("iframe").src = artist.lyd;
    popup.querySelector(".projekt_titel").textContent = projekt.title.rendered;
    popup.querySelector(".teaser_tekst").textContent = projekt.teaser_tekst;
    popup.querySelector(".projekt_beskriv").textContent = projekt.beskrivelse_af_projekt;
    popup.querySelector(".til_laererne").textContent = projekt.til_laererne;
    popup.querySelector(".til_elever").textContent = projekt.til_elev;

  }

  // ved klik på luk-knappen forsvinder popup-vindue
  lukKnap.addEventListener("click", () => (popup.style.display = "none"));
  lukKnap.addEventListener(
    "click",
    () => (document.querySelector(".nav").style.position = "sticky")
  );
  hentData();
}

function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}


</script>
	</div><!-- #primary -->

<?php
get_footer();
