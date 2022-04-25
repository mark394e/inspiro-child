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



	<div id="primary" class="content-area">
		<main id="main" class="site-main">

    <article>
      <div class="col_left">
        <img src="" alt="" class="billede" />
        <div>
          <p class="verdensmaal">Fokus:</p>
          <p class="uddannelsestrin">Udannelsestrin:</p>
          <p class="skolenavn">Skolenavn:</p>
          <p class="kontakt">Kontakt:</p>
        </div>
        </div>
        <div>
        <h2 class="projekt_titel"></h2>
        <p class="teaser_tekst"></p>
        <p class="projekt_beskriv"></p>
        <h3>Til Lærerne:</h3>
        <p class="til_laererne"></p>
        <h3>Til eleverne:</h3>
        <p class="til_elever"></p>
        </div>
      </article>

		</main><!-- #main -->
		<style>

article{
      display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
}

.billede{
  max-width: 80%;
}

.col_left{
  display: flex;
  flex-flow: column;
  place-items: center;
}


		</style>
<script>

  let projekt;

  const dbUrl = "http://hoffmannlund.dk/kea/09_CMS/unesco-asp/wp-json/wp/v2/projekt/" + <?php echo get_the_ID() ?>;
  console.log(dbUrl)

  async function getJson(){
    console.log("getJson")
    const data = await fetch(dbUrl);
    projekt = await data.json();
    visProjekter();
  }

  function visProjekter(){
    console.log("visProjekt")
    document.querySelector(".billede").src = projekt.billede.guid;
    document.querySelector(".projekt_titel").textContent = projekt.title.rendered;
    document.querySelector(".teaser_tekst").textContent = projekt.teaser_tekst;
    document.querySelector(".projekt_beskriv").textContent = projekt.beskrivelse_af_projekt;
    document.querySelector(".til_laererne").textContent = projekt.til_laererne;
    document.querySelector(".til_elever").textContent = projekt.til_elev;
    document.querySelector(".verdensmaal").textContent = "Fokus: " + projekt.verdensmaal;
    document.querySelector(".uddannelsestrin").textContent = "Uddannelsestrin: " + projekt.uddannelsestrin;
    document.querySelector(".skolenavn").textContent = "Skole: " + projekt.skolenavn;
    document.querySelector(".kontakt").textContent = "Kontakt: " + projekt.fulde_navn + ", " + projekt.email;

  }


  
getJson();
</script>
	</div><!-- #primary -->

<?php
get_footer();
