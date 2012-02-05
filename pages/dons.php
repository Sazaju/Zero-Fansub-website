<?php
	$content = "[url=http://www.medecinsdumonde.org/][imgl]images/interface/medecins.png[/imgl][/url][title]Dons[/title][title=2]Informations[/title]
Tu viens de cliquer sur le lien des dons pour un des sites de la [partner=db0company]db0 company[/partner], et pour cela, nous t'en remercions.
The [partner=db0company]db0 company[/partner] n'est pas une association à but lucratif. Et pourtant, nous réclamons des dons.
Pourquoi ?
Tenir tous les sites de la [partner=db0company]db0 company[/partner] n'est pas gratuit, et nous payons actuellement nos serveurs dans les environs de 250€ par mois. C'est une sacrée somme, c'est pourquoi une petite aide de la part des utilisateurs du site est la bienvenue, si petite soit-elle.

Dans tout les cas, un don n'est jamais perdu : Soit il aide au paiement mensuel des serveurs, soit il est reversé à l'association humanitaire medecin du monde.
L'argent reversé à Medecin du monde ne l'est pas directement, mais db0 paie 10€ par mois pour cette association de sa poche en plus des serveurs. Nous espèrons avoir du soutien auprès de vous pour le site tout comme l'association humanitaire.
[separator]
[url=https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=mba_06%40hotmail%2efr&item_name=Zero&no_shipping=0&no_note=1&tax=0&currency_code=EUR&lc=FR&bn=PP%2dDonationsBF&charset=UTF%2d8][img]images/interface/dons.png[/img][/url]";
	PageContent::getInstance()->addComponent(Format::convertTextToHTML($content));
?>