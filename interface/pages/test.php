<?php
	$string = '
[time=1234567890,user="admin"]

+C.f1(string,optional)
C.f1.type=integer
C.f1.mandatory=mandatory
+C.f2(string5,optional)
+C.f3(string,optional)
+C.f4(boolean,optional)

C=[f1,f2,f4]

+C[1,"abc",true]()
-C[1,"abc",true]
+C[2,null,false]()
C[2,null,false].f3="Lorem ipsum..."
C[2,null,false].f2="test"
C[2,"test",false].f3="Dolor sit amet..."

# Ceci est un commentaire

+Dossier.id(string,optional)
Dossier.id.type=integer
Dossier.id.mandatory=mandatory
+Dossier.title(string50,optional)

Dossier=[id]

+Dossier[1]()
-Dossier[1]
+Dossier[2](title="abc")
Dossier[2].id=3
Dossier[3].title="azerty"
';
	echo "<div class='xdebug-var-dump' style='line-height: 50%;'>";
	$manager = new PatchManager();
	$patch = new Patch($string);
	echo "</div>";
?>
