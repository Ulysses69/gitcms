Summary
I Français
II English
III Licence
IV ...

I Français
Installation
- Téléchargez le fichier pagepeel.zip
- Décompressez le fichier, puis transférez le dossier complet pagepeel dans le dossier "frog09x\frog\plugins".
- Rendez-vous dans l'interface d'administration de Frog, choisissez l'onglet "Administration", activez le plugin "pagepeel".
- Insérez le code <?php pagepeel($this); ?> entre les balises <head> et </head> de votre gabarit.
- Insérez le code suivant dans la page qui affichera la bannière :
<script type="text/javascript">
writeObjects();
</script>

Personnalisation
- Dans l'espace "Administration", onglet "Page", créez un onglet "pagepeel".
- Dans cet onglet pagepeel ajoutez le code suivant :
<?php
echo "var pagearSmallImg = 'http://www.webpicasso.de/blog/flash/pageear/pageear_s.jpg';\n"; // petite image
echo "var pagearSmallSwf = '".URL_PUBLIC."frog/plugins/pagepeel/pageear_s.swf';\n";
echo "var pagearBigImg = 'http://www.webpicasso.de/blog/flash/pageear/pageear_b.jpg'; \n"; // grande image
echo "var pagearBigSwf = '".URL_PUBLIC."frog/plugins/pagepeel/pageear_b.swf';\n";
echo "var jumpTo = 'http://www.webpicasso.de/blog/'\n"; // adresse du site à afficher
?>
- La petite image doit faire 100x100 pixels, la grande image doit faire 500x500 pixels, elles doivent être au format JPG.

Cette opération peut être ajoutée dans toutes les pages que vous voulez.

II English
Installation
- Extract the pagepeel.zip file and copy the "pagepeel" folder to the plugins directory "frog09x\frog\plugins".
- Login to the administration panel of your Frog install.
- Navigate to Administration panel.
- Click on the check box in front of Pagepeel.
- Insert the code <?php pagepeel($this); ?> between <head> and </head> of your layout.
- Insert the following code in your website page
<script type="text/javascript">
writeObjects();
</script>

Customisation
- In the "Administration" area, zone "Page", extend the content with new tab "pagepeel".
- In the pagepeel tab add the following code:
<?php
echo "var pagearSmallImg = 'http://www.webpicasso.de/blog/flash/pageear/pageear_s.jpg';\n"; // small image
echo "var pagearSmallSwf = '".URL_PUBLIC."frog/plugins/pagepeel/pageear_s.swf';\n";
echo "var pagearBigImg = 'http://www.webpicasso.de/blog/flash/pageear/pageear_b.jpg'; \n"; // large image
echo "var pagearBigSwf = '".URL_PUBLIC."frog/plugins/pagepeel/pageear_b.swf';\n";
echo "var jumpTo = 'http://www.webpicasso.de/blog/'\n"; // URL of the website
?>
- The small image must be 100x100 pixels, the large image must be 500x500 pixels, their extension must be JPG.

You can repeat this operation in all your website pages.

III Licence agreement
The offered software is property of Christian Harz, webpicasso media (http://www.webpicasso.de/).

The software is Freeware and may be used on private and commercial web pages free of charge, as long as you agree to the following license:

	* The copyright may not be changed. The copyright only belongs to Christian Harz, webpicass media.
	* It is not allowed to use the software on pages with illegal, pornography or ethicalally doubtful contents.
	* Advertising link / Backlinks to webpicasso media, so far available, may not be removed.
	* The software may not be sold (e.g. Ebay) or make money in any way, also not as part of another software or a script packages.
	* It is not allowed to use pageear or parts of it in own public scripts / projects without author agreement.
	* On commercial pages set a backlink to webpicasso media.

Webpicasso media is not responsible for damage and legal consequences, which can result from the use of the software.

IV ...
Merci à Philippe Archambault pour ce script : Frog.
