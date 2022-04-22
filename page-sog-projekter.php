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

<nav id="filtrering"><button data-projekt="alle">Alle</button></nav>

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
        <p class="til_lærererne"></p>
        <p class="til_elever"></p>
      </article>
    </section>

<template class="loopview">
          <article>
            <img src="" alt="" class="billede" />
            <h2 class="projekt_titel"></h2>
            <p class="teaser_tekst"></p>
            <p class="verdensmaal"></p>
          </article>
      </template>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		</main><!-- #main -->
		<style>

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
justify-content: right;
margin-bottom: 100px;
}

 main {
    max-width: 1200px;
    margin: 0 auto;
  }

.navn {
  color: #d87236;
}

.genre,
.korttekst {
  color: #f2f2f2;
}

			 main {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 50px;
    margin-top: 40px;
  }

  article {
     padding: 10px;
    cursor: pointer;
    border-radius: 8px;
    transition-duration: 0.4s;
    place-content: center;
	background-color: #23b7d9;
  }

  article:hover {
    box-shadow: 5px 5px #147ca6;
  }

  main {
    max-width: 1200px;
    margin: auto 20px auto 20px;
  }

  #popup {
    display: none;
    position: fixed;
    left: 0;
    top: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.8);
    overflow: scroll;
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
padding: 2em 0 0 5.5em;
font-size: 2em;
font-weight: bolder;
color: white;
cursor: pointer;
  }

  #luk:hover {
    color: #032f40;
  }

  .langtekst{
	  font-size: 0.8rem;
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

//   // Lytter efter "klik" på menu-knap til burgermenu
//   document.querySelector("#menuknap").addEventListener("click", toggleMenu);

//   // Toggler klassen "hidden" hver gang der klikkes på menu-knappen
//   function toggleMenu() {
//     console.log("toggleMenu");
//     document.querySelector("#menu").classList.toggle("hidden");

//     let erSkjult = document.querySelector("#menu").classList.contains("hidden");

//     // Ændre menu-knappens "udseende" alt efter om burgermenuen er skjult eller ej
//     if (erSkjult == true) {
//       document.querySelector("#menuknap").textContent = "☰";
//     } else {
//       document.querySelector("#menuknap").textContent = "X";
//     }
//   }

//   const filterKnapper = document.querySelectorAll(".nav button");

//   const filterKnapperBurger = document.querySelectorAll("#menu button");

//   //  sætter eventlistener på alle knapper i burgermenu og lytter efter klik på knapperne
//   filterKnapperBurger.forEach((knap) =>
//     knap.addEventListener("click", filtrerInfluencer)
//   );

//   // sætter eventlistener på alle knapper i nav'en og lytter efter klik på knapperne
//   filterKnapper.forEach((knap) =>
//     knap.addEventListener("click", filtrerInfluencer)
//   );

//   // sætter filter til at være ligmed den data-attribut vi har defineret i HTML; Markus, Sandra, Filippa eller Dino
//   function filtrerInfluencer() {
//     console.log("filtrerInfluencer");
//     filter = this.dataset.influencer;

//     // fjerner klassen .valgt og lægger den til den knap der er trykket på
//     document.querySelector(".valgt").classList.remove("valgt");
//     this.classList.add("valgt");
//     visArtister();
//     visBloggere();

//     // jeg sætter h1'erens tekstindhold ligmed tekstindholdet af den knap der er trykket på
//     header.textContent = this.textContent;
//   }

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
		  document.querySelector("#filtrering").innerHTML +=`<button class="filter" data-artist="${cat.id}">${cat.name}</button>`
	  })
	  addEventListenersToButtons();
  }

  function addEventListenersToButtons(){
			document.querySelectorAll("#filtrering button").forEach(elm =>{
				elm.addEventListener("click", filtrering);
			})
		};

		function filtrering(){
			filter = this.dataset.projekt;
			console.log(filter);

			visProjekter();
		}

//   function visBloggere() {
//     console.log("visBloggere");

//     section.textContent = ""; // Her resetter jeg DOM'en ved at tilføje en tom string

//     // for hver blogger i arrayet, skal der tjekkes om de opfylder filter-kravet og derefter vises i DOM'en.
//     bloggere.forEach((blogger) => {
//       if (filter == blogger.influencer) {
//         document.querySelector(".tekstOmAlle p").textContent = "";
//         const klon2 = template2.cloneNode(true);
//         klon2.querySelector(".bloggerBillede").src =
//           "img/" + blogger.billede2 + ".jpg";
//         klon2.querySelector(".bloggerTekst").textContent = blogger.omos;

//         // tilføjer klon-template-elementet til section-elementet (så det hele vises i DOM'en)
//         section.appendChild(klon2);
//         // tilføjer section-elementet til min "header" der har klassen .splash
//         document.querySelector(".splash").appendChild(section);
//       }
//       // Hvis filteret er sat til alle, indsættes denne tekst
//       else if (filter == "alle") {
//         document.querySelector(".tekstOmAlle p").textContent =
//           "Fire af landets mest etablerede musikbloggere fra hovedstaden peger på deres 2022 favoritter. Se deres nøje udvalgte bands og artister, og læs hvorfor netop disse kunstnere kommer til at blinke på stjernehimlen i det nye år. Bliv inspireret af både etablerede og nye acts, som forhåbentligt leverer flere hits i 2022.";
//       }
//     });
//   }

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
          .addEventListener("click", () => visDetaljer(projekt));

        // tilføjer klon-template-elementet til main-elementet (så det hele vises i DOM'en)
        main.appendChild(klon);
      }
    });
  }

  // tilføjer objekter fra arrayet (for hver artist) til popup-vindue. Samt sætter cursor til default, så man ikke tror man kan klikke på elementet igen.
  function visDetaljer(artist) {
    console.log(artist);
    // document.querySelector(".nav").style.position = "inherit";
    article.style.cursor = "default";
    popup.style.display = "block";
    popup.querySelector(".billede").src = artist.billede.guid;
    popup.querySelector(".billede").style.maxWidth = "50%";
    // popup.querySelector("iframe").src = artist.lyd;
    popup.querySelector(".navn").textContent = artist.title.rendered;
    popup.querySelector(".langtekst").textContent = artist.lang_beskriv;
    popup.querySelector(".udvalgt").textContent = "Lyt til: " + artist.udvalgt;
    popup.querySelector(".influencer").textContent =
      "Udvalgt af " + artist.influencer;
  }

//   // ved klik på luk-knappen forsvinder popup-vindue
  lukKnap.addEventListener("click", () => (popup.style.display = "none"));
  lukKnap.addEventListener(
    "click",
    () => (document.querySelector(".nav").style.position = "sticky")
  );
  hentData();
}
</script>
	</div><!-- #primary -->

<?php
get_footer();
