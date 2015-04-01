<?php
	$page = PageContent::getInstance();
	
	$content = "[title]Contact[/title]


Avant de nous contacter, voici des questions typiques qu'on peut nous poser. Merci de vous y référer avant de nous envoyer un e-mail.

[left]
[title=2]Accès à nos sous-titres[/title]

[b]Est-ce que je pourrais avoir vos fichiers de sous-titres ?[/b]

Vous pouvez les extraire de nos épisodes pour ceux qui sont en [i]softsub[/i], mais il n'est pas prévu de fournir nos fichiers sous-titres seuls. On fait beaucoup d'effort pour obtenir des sous-titres qui suivent correctement la vidéo, mais cela implique de se fier à une version de la vidéo en particulier, notamment pour les éditions. Vu qu'on met l'accent sur la qualité, ça n'a donc pas de sens de fournir les sous-titres seuls au risque de ne pas être adaptés à la vidéo que vous utiliserez.

[b]Moi, ça ne me dérange pas, je peux les avoir quand même ?[/b]

Bien que certains d'entre nous soient pour, ce n'est pas le cas de toute la team, et il est important que chacun y trouve son compte. Désormais, on prévoit de faire toutes nos sorties en [i]softsub[/i], chacun pouvant donc désactiver nos sous-titres et même les extraire sans problèmes. Cependant, ça ne veut pas dire qu'on doive aussi fournir nos anciens sous-titres, et pour l'instant on n'en a pas l'intention.

[b]Alors on n'aura jamais vos sous-titres pour les anciennes séries ?[/b]

Si on trouve des vidéos de meilleures qualités (BD) il est prévu de les refaire, ce qui implique de revoir la traduction si on l'estime nécessaire. Ces nouvelles versions devraient sortir en [i]softsub[/i] et vous pourriez en extraire les sous-titres. Mais sans ces révisions, il n'est pas prévu de fournir les sous-titres ni de refaire nos vidéos en [i]softsub[/i] juste pour que vous puissiez les extraire.

[b]Mais c'est pas logique. C'est quoi ces raisons à deux balles ?[/b]

C'est nos raisons. Et qu'elles vous plaisent ou non, si on vous les donne, c'est pour satisfaire votre curiosité, pas pour en débattre. Mais soyons clairs : rien ne vous empêche de faire l'effort de les recopier et de refaire le time et tout ce qui va avec. Si vous n'avez pas la motivation de le faire, c'est que ces sous-titres ne vous tiennent pas plus à cœur que ça. Vous avez vos valeurs, nous les nôtres. Le fansub est une notion de partage, et nous on partage des vidéos, pas des sous-titres.

[title=2]Recrutement[/title]

[b]Je veux vous rejoindre, je fais comment ?[/b]

Pour nous rejoindre, c'est [url=?page=recruit]par là[/url]. Merci de bien lire et de faire votre candidature sérieusement. Vous n'êtes censés la faire qu'une seule fois, donc autant y apporter du soin, ce qui nous fera gagner du temps et augmentera vos chances de convaincre que vous n'êtes pas un kikoolol qui passait parce qu'il a vu de la lumière sous la porte.

[b]Mais j'aime pas les forums. On ne peut pas faire ça par e-mail ?[/b]

Non. Toute l'équipe passe par le forum, dire que chacun puisse être mis au courant et donner son avis. De plus, c'est à ceux en charge des différentes tâches de juger ceux qui postulent pour ces tâches et de leur assigner des travaux. Passer par un e-mail centralisé n'est donc pas adapté. Après acceptation de la candidature, chacun gère comme il l'entend, il est donc possible (c'est le cas pour certains) de communiquer quasiment exclusivment par e-mail. Mais la candidature doit être impérativement faite sur le forum en suivant notre procédure.

[title=2]Divers[/title]

[b]J'ai trouvé un bug, je fais quoi ?[/b]

Pour nous signaler un bug, c'est [url=?page=bug]par là[/url].

[/left]
===================

Si vous n'avez pas trouvé de réponse à vos questions, vous pouvez nous contacter via cet e-mail :


[size=25px][mail]zero.fansub@gmail.com[/mail][/size]";
	
	$contact = new SimpleTextComponent(Format::convertTextToHTML($content));

	
	$page->addComponent($contact);
?>