<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Supglove
 */
?>
	<?php
	/*
	 *  supro_site_content_close - 100
	 */
	do_action( 'supro_site_content_close' );
	?>
</div><!-- #content -->

	<?php
	/*
	 * supro_footer_newsletter - 10
	 * supro_footer_newsletter_fix -20
	 */
	do_action( 'supro_before_footer' );
	?>

	<footer id="colophon" class="site-footer">
		<?php do_action( 'supro_footer' ) ?>
	</footer><!-- #colophon -->

	<?php do_action( 'supro_after_footer' ) ?>
</div><!-- #page -->
<div id="hiddencartopen" class="hiddenclick"></div>

<!-- 🛠 Bulletproof CSS language visibility fix -->
<style>
  .link-en, .link-es, .link-pt-br, .link-fr {
    display: none !important;
  }
  html[lang="en-US"] body .link-en,
  html[lang="es"] body .link-es,
  html[lang="pt-BR"] body .link-pt-br,
  html[lang="fr"] body .link-fr {
    display: block !important;
  }
</style>

<!-- 🔁 Shortcode compatibility patch for pt-BR -->
<script>
  if (document.documentElement.lang === "pt-BR") {
    document.documentElement.lang = "pt-br";
  }
</script>

<?php wp_footer(); ?>
</body>
</html>


