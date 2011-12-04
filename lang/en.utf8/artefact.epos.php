<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2010 Catalyst IT Ltd and others; see:
 *                         http://wiki.mahara.org/Contributors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    mahara
 * @subpackage artefact-epos
 * @author     Jan Behrens
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011 Jan Behrens, jb3@informatik.uni-bremen.de
 *
 */

defined('INTERNAL') || die();

//general
$string['pluginname'] = 'epos';
$string['goals'] = 'Learning Objectives';
$string['selfevaluation'] = 'Self-evaluation';
$string['dossier'] = 'Dossier';
$string['diary'] = 'Diary';
$string['biography'] = 'Biography';
$string['mylanguages'] = 'My Languages';
$string['myexperience'] = 'My Experience';
$string['mydiary'] = 'My Diary';

//interaction
$string['add'] = 'Add';
$string['cancel'] = 'Cancel';
$string['del'] = 'Delete';
$string['edit'] = 'Edit';
$string['save'] = 'Save';

//notifications
$string['addedlanguage'] = 'Language has been added.';
$string['confirmdel'] = 'Are you sure you want to delete this language?';
$string['deletedlanguage'] = 'Language has been deleted.';
$string['nolanguageselected1'] = 'You have not selected any languages. Go to "';
$string['nolanguageselected2'] = '" to add one.';
$string['savedchecklist'] = 'Your checklist has been saved.';

//vocabulary
$string['competence'] = 'Competence';
$string['level'] = 'Competence level';
$string['descriptors'] = 'Descriptors';
$string['descriptorset'] = 'Descriptor set';
$string['languages'] = 'Languages';
$string['subjects'] = 'Subjects';
$string['goal'] = 'Goal';

//add subject form
$string['subjectform.subject'] = 'Subject';
$string['subjectform.title'] = 'Title';
$string['subjectform.descriptorset'] = 'Descriptors';

//descriptor sets
$string['descriptorset.cercles.de'] = 'CercleS Deskriptoren auf Deutsch';
$string['descriptorset.cercles.en'] = 'CercleS descriptors in English';
$string['descriptorset.elc.de'] = 'ELC Deskriptoren auf Deutsch';
$string['descriptorset.elc.en'] = 'ELC descriptors in English';
$string['descriptorset.elc.fr'] = 'ELC descripteurs en français';
$string['descriptorset.schule.de'] = 'Schule Deskriptoren auf Deutsch';

//evaluation levels
$string['eval0'] = 'not at all';
$string['eval1'] = 'satisfactory';
$string['eval2'] = 'good';

//TODO: the following should be like $string['descriptorset.elc.listening']

//competences ELC
$string['listening'] = 'Listening';
$string['reading'] = 'Reading';
$string['spokeninteraction'] = 'Spoken interaction';
$string['spokenproduction'] = 'Spoken production';
$string['writing'] = 'Writing';

//competence levels ELC
$string['a1'] = 'A1';
$string['a2'] = 'A2';
$string['b1'] = 'B1';
$string['b2'] = 'B2';
$string['c1'] = 'C1';
$string['c2'] = 'C2';


/*
 * descriptors ELC German
 */
 
$string['elc_de_li_a1_1'] = 'Ich kann verstehen, wenn jemand sehr langsam und deutlich mit mir spricht und wenn lange Pausen mir Zeit lassen, den Sinn zu erfassen.';
$string['elc_de_li_a1_2'] = 'Ich kann eine einfache Wegerklärung, wie man zu Fuß oder mit einem öffentlichen Verkehrsmittel von A nach B kommt, verstehen.';
$string['elc_de_li_a1_3'] = 'Ich kann Fragen und Aufforderungen verstehen, mit denen man sich langsam und sorgfältig an mich wendet, und ich kann kurzen einfachen Anweisungen folgen.';
$string['elc_de_li_a1_4'] = 'Ich kann Zahlen, Preisangaben und Uhrzeiten verstehen.';
$string['elc_de_li_a2_1'] = 'Ich kann verstehen, was man in einfachen Alltagsgesprächen langsam und deutlich zu mir sagt; es ist möglich, sich mir verständlich zu machen, wenn die Sprechenden sich die nötige Mühe machen können.';
$string['elc_de_li_a2_2'] = 'Ich kann im Allgemeinen das Thema von Gesprächen, die in meiner Gegenwart geführt werden, erkennen, wenn langsam und deutlich gesprochen wird.';
$string['elc_de_li_a2_3'] = 'Ich kann Sätze, Ausdrücke und Wörter verstehen, wenn es um Dinge von ganz unmittelbarer Bedeutung geht (z. B. ganz grundlegende Informationen zu Person, Familie, Einkaufen, Arbeit, nähere Umgebung).';
$string['elc_de_li_a2_4'] = 'Ich kann die Hauptsache von dem, was in kurzen, einfachen und klaren Durchsagen oder Mitteilungen gesagt wird, mitbekommen.';
$string['elc_de_li_a2_5'] = 'Ich kann kurzen, langsam und deutlich gesprochenen Tonaufnahmen die Hauptinformation entnehmen, wenn es um vorhersehbare alltägliche Dinge geht.';
$string['elc_de_li_a2_6'] = 'Ich kann die Hauptinformation von Fernsehmeldungen über Ereignisse, Unglücksfälle usw. erfassen, wenn der Kommentar durch Bilder unterstützt wird.';
$string['elc_de_li_b1_1'] = 'Ich kann verstehen, was man in einem Alltagsgespräch zu mir sagt, falls deutlich gesprochen wird; ich muss aber manchmal darum bitten, bestimmte Wörter und Wendungen zu wiederholen.';
$string['elc_de_li_b1_2'] = 'Ich kann normalerweise einem längeren Gespräch, das in meiner Gegenwart geführt wird, in den wesentlichen Punkten folgen, vorausgesetzt es wird deutlich gesprochen und Standardsprache verwendet.';
$string['elc_de_li_b1_3'] = 'Ich kann einer kurzen Erzählung zuhören und Hypothesen dazu bilden, was als Nächstes geschehen wird.';
$string['elc_de_li_b1_4'] = 'Ich kann in Radionachrichten und in einfacheren Tonaufnahmen über vertraute Themen die Hauptpunkte verstehen, wenn relativ langsam und deutlich gesprochen wird.';
$string['elc_de_li_b1_5'] = 'Ich kann in Fernsehsendungen über vertraute Themen die Hauptpunkte erfassen, wenn einigermaßen langsam und deutlich gesprochen wird.';
$string['elc_de_li_b1_6'] = 'Ich kann einfache technische Informationen, z. B. zur Bedienung von Geräten des täglichen Gebrauchs, verstehen.';
$string['elc_de_li_b1_7'] = 'Ich kann in Diskussionen (z.B. in einem Seminar, bei einer Podiums - oder Fernsehdiskussion) die Hauptpunkte erfassen, wenn es um ein vertrautes Thema aus meinem Fachgebiet geht, vorausgesetzt es wird deutlich gesprochen und Standardsprache verwendet.';
$string['elc_de_li_b1_8'] = 'Ich kann in einer Vorlesung Notizen zu den Hauptaussagen machen, die für den eigenen Gebrauch genügen, sofern das Thema zu meinem Fachgebiet gehört und der Vortrag klar und gut strukturiert ist.';
$string['elc_de_li_b2_1'] = 'Ich kann im Detail verstehen, was man mir in der Standardsprache sagt – auch wenn es in der Umgebung störende Geräusche gibt.';
$string['elc_de_li_b2_2'] = 'Ich kann einer Vorlesung oder einem Vortrag innerhalb meines Fach- oder Interessengebiets folgen, wenn mir die Thematik vertraut ist und wenn der Aufbau einfach und klar ist.';
$string['elc_de_li_b2_3'] = 'Ich kann im Radio die meisten Dokumentarsendungen, in denen Standardsprache gesprochen wird, verstehen und die Stimmung, den Ton usw. der Sprechenden heraushören.';
$string['elc_de_li_b2_4'] = 'Ich kann am Fernsehen Reportagen, Live-Interviews, Talk-Shows, Fernsehspiele und auch die meisten Filme verstehen, sofern die Standardsprache und nicht Dialekt gesprochen wird.';
$string['elc_de_li_b2_5'] = 'Ich kann die Hauptpunkte von komplexen Redebeiträgen zu konkreten und abstrakten Themen verstehen, wenn in der Standardsprache gesprochen wird; ich verstehe in meinem Spezialgebiet auch Fachdiskussionen.';
$string['elc_de_li_b2_6'] = 'Ich kann verschiedene Strategien anwenden, um etwas zu verstehen, z. B. auf die Hauptpunkte hören oder Hinweise aus dem Kontext nutzen, um mein Verstehen zu überprüfen.';
$string['elc_de_li_b2_7'] = 'Ich kann eine strukturierte Vorlesung über ein vertrautes Thema verstehen und mir die Punkte notieren, die mir wichtig erscheinen, auch wenn ich manchmal an Wörtern hängen bleibe und deshalb einen Teil der Informationen verpasse.';
$string['elc_de_li_c1_1'] = 'Ich kann längeren Redebeiträgen und Gesprächen folgen, auch wenn sie nicht klar strukturiert sind und wenn Zusammenhänge nicht explizit ausgedrückt werden.';
$string['elc_de_li_c1_2'] = 'Ich kann ein breites Spektrum von Redewendungen und umgangssprachlichen Ausdrucksweisen verstehen und Wechsel im Stil und Ton erkennen.';
$string['elc_de_li_c1_3'] = 'Ich kann auch bei schlechter Übertragungsqualität aus öffentlichen Durchsagen – z. B. am Bahnhof oder an Sportveranstaltungen – Einzelinformationen heraushören.';
$string['elc_de_li_c1_4'] = 'Ich kann komplexe technische Informationen verstehen, z. B. Bedienungsanleitungen oder genaue Angaben zu vertrauten Produkten und Dienstleistungen.';
$string['elc_de_li_c1_5'] = 'Ich kann Vorlesungen, Reden und Berichte im Rahmen meines Berufs, meiner Ausbildung oder meines Studiums verstehen, auch wenn sie inhaltlich und sprachlich komplex sind.';
$string['elc_de_li_c1_6'] = 'Ich kann ohne allzu große Mühe Spielfilme verstehen, auch wenn darin viel saloppe Umgangssprache und viele Redewendungen vorkommen.';
$string['elc_de_li_c1_7'] = 'Ich kann den Inhalt von Radio- und Fernsehsendungen verstehen, die meinen Fachbereich betreffen, auch wenn sie anspruchsvoll und sprachlich komplex sind.';
$string['elc_de_li_c1_8'] = 'Ich kann im Detail verstehen, wenn über abstrakte, komplexe Themen auf fremden Fachgebieten gesprochen wird, muss jedoch manchmal Einzelheiten bestätigen lassen, besonders wenn mit wenig vertrautem Akzent gesprochen wird.';
$string['elc_de_li_c1_9'] = 'Ich kann einer Vorlesung zu Themen meines Fachgebietes detaillierte Notizen machen, und zwar so exakt und nahe am Original, dass diese Notizen auch für andere nützlich sind.';
$string['elc_de_li_c2_1'] = 'Ich habe keinerlei Schwierigkeit, gesprochene Sprache zu verstehen, gleichgültig ob „live“ oder in den Medien, und zwar auch, wenn schnell gesprochen wird. Ich brauche nur etwas Zeit, mich an einen besonderen Akzent zu gewöhnen.';
$string['elc_de_li_c2_2'] = 'Ich kann Fachvorträge oder Präsentationen verstehen, die viele umgangssprachliche oder regional gefärbte Ausdrücke oder auch fremde Terminologie enthalten.';
$string['elc_de_li_c2_3'] = 'Ich bemerke in Vorlesungen und Seminaren, was nur implizit gesagt wird und worauf nur angespielt wird und kann mir dazu ebenso Notizen machen wie zu dem, was ein Sprecher direkt ausdrückt.';
$string['elc_de_re_a1_1'] = 'Ich kann in Zeitungsartikeln Angaben zu Personen (Wohnort, Alter usw.) verstehen. ';
$string['elc_de_re_a1_2'] = 'Ich kann auf Veranstaltungskalendern oder Plakaten ein Konzert oder einen Film aussuchen und Ort und Anfangszeit entnehmen. ';
$string['elc_de_re_a1_3'] = 'Ich kann einen Fragebogen (bei der Einreise oder bei der Anmeldung im Hotel) so weit verstehen, dass ich die wichtigsten Angaben zu meiner Person machen kann (z. B. Name, Vorname, Geburtsdatum, Nationalität). ';
$string['elc_de_re_a1_4'] = 'Ich kann Wörter und Ausdrücke auf Schildern verstehen, denen man im Alltag oft begegnet (wie z. B. „Bahnhof“, „Parkplatz“, „Rauchen verboten“, „rechts bleiben“). ';
$string['elc_de_re_a1_5'] = 'Ich kann die wichtigsten Befehle eines Computerprogramms verstehen, wie z. B. „Speichern“, „Löschen“, „Öffnen“, „Schließen“. ';
$string['elc_de_re_a1_6'] = 'Ich kann kurze, einfache schriftliche Wegerklärungen verstehen. ';
$string['elc_de_re_a1_7'] = 'Ich kann kurze, einfache Mitteilungen auf Postkarten verstehen, z. B. Feriengrüße. ';
$string['elc_de_re_a1_8'] = 'Ich kann in Alltagssituationen einfache schriftliche Mitteilungen von Bekannten und Mitarbeitern / Mitarbeiterinnen verstehen, z. B. „Bin um 4 Uhr zurück“.';
$string['elc_de_re_a2_1'] = 'Ich kann Meldungen oder einfachen Zeitungsartikeln, in denen Zahlen und Namen eine wichtige Rolle spielen und die klar gegliedert sind und mit Bildern arbeiten, wichtige Informationen entnehmen. ';
$string['elc_de_re_a2_2'] = 'Ich kann einen einfachen persönlichen Brief verstehen, in dem mir jemand von Dingen aus dem Alltag schreibt oder mich danach fragt. ';
$string['elc_de_re_a2_3'] = 'Ich kann einfache schriftliche Mitteilungen von Bekannten oder Mitarbeitern verstehen (z. B. wann man sich zum Fußball spielen trifft oder dass ich früher zur Arbeit kommen soll). ';
$string['elc_de_re_a2_4'] = 'Ich kann in Informationsblättern über Freizeitaktivitäten, Ausstellungen usw. die wichtigsten Informationen finden. ';
$string['elc_de_re_a2_5'] = 'Ich kann in der Zeitung die Kleininserate überfliegen, die gesuchte Rubrik finden und die wichtigsten Informationen herauslesen, zum Beispiel Größe und Preis von Wohnungen, Autos, Computern usw. ';
$string['elc_de_re_a2_6'] = 'Ich kann einfache Gebrauchsanweisungen für Apparate verstehen (z. B. für das öffentliche Telefon). ';
$string['elc_de_re_a2_7'] = 'Ich kann Meldungen und einfache Hilfetexte in Computerprogrammen verstehen. ';
$string['elc_de_re_a2_8'] = 'Ich kann kurze Erzählungen verstehen, die von alltäglichen Dingen handeln und in denen es um Themen geht, die mir vertraut sind, wenn der Text in einfacher Sprache geschrieben ist.';
$string['elc_de_re_b1_1'] = 'Ich verstehe die wesentlichen Punkte in kürzeren Zeitungsartikeln über aktuelle und vertraute Themen. ';
$string['elc_de_re_b1_2'] = 'Ich kann die Bedeutung einzelner unbekannter Wörter aus dem Kontext erschließen und so den Sinn von Äußerungen ableiten, wenn mir die Thematik vertraut ist. ';
$string['elc_de_re_b1_3'] = 'Ich kann kurze Texte überfliegen (z. B. Meldungen in Kürze) und wichtige Fakten und Informationen finden (z. B. wer was wo gemacht hat). ';
$string['elc_de_re_b1_4'] = 'Ich kann einfache Mitteilungen und Standardbriefe verstehen (z. B. von Geschäften, Vereinen oder Behörden). ';
$string['elc_de_re_b1_5'] = 'In Privatbriefen oder E-Mails verstehe ich gut genug, was über Ereignisse, Gefühle oder Wünsche geschrieben wird, um regelmäßig mit einem Freund oder einer Freundin korrespondieren zu können. ';
$string['elc_de_re_b1_6'] = 'Ich kann die Handlung einer klar aufgebauten Erzählung verstehen und erkennen, welches die wichtigsten Episoden und Ereignisse sind und inwiefern sie bedeutsam sind. ';
$string['elc_de_re_b1_7'] = 'Ich kann in klar geschriebenen argumentativen Texten die wesentlichen Schlussfolgerungen erkennen. ';
$string['elc_de_re_b1_8'] = 'Ich kann unkomplizierte Sachtexte über Themen, die mit den eigenen Interessen und Fachgebieten in Zusammenhang stehen, mit befriedigendem Verständnis lesen. ';
$string['elc_de_re_b1_9'] = 'Ich kann längere Texte aus meinem Fachgebiet nach gewünschten Informationen durchsuchen und Informationen aus verschiedenen Texten oder Textteilen zusammentragen, um eine bestimmte Aufgabe zu lösen.';
$string['elc_de_re_b2_1'] = 'Ich kann rasch den Inhalt und die Wichtigkeit von Nachrichten, Artikeln und Berichten über Themen, die mit meinen Interessen oder meinem Beruf zusammenhängen, erfassen und entscheiden, ob sich ein genaueres Lesen lohnt. ';
$string['elc_de_re_b2_2'] = 'Ich kann Artikel und Berichte über aktuelle Fragen lesen und verstehen, in denen die Schreibenden eine bestimmte Haltung oder einen bestimmten Standpunkt vertreten. ';
$string['elc_de_re_b2_3'] = 'Ich kann Texte zu Themen aus meinem Fach- und Interessenbereich im Detail verstehen. ';
$string['elc_de_re_b2_4'] = 'Ich kann auch Fachartikel, die über mein eigenes Gebiet hinausgehen, lesen und verstehen, wenn ich zur Kontrolle ab und zu im Wörterbuch nachschlagen kann. ';
$string['elc_de_re_b2_5'] = 'Ich kann Kritiken lesen, in denen es um den Inhalt und die Beurteilung von kulturellen Ereignissen geht (Filme, Theater, Bücher, Konzerte), und die Hauptaussagen zusammenfassen. ';
$string['elc_de_re_b2_6'] = 'Ich kann Korrespondenz zu Themen innerhalb meines Fach-, Studien- oder Interessengebietes lesen und die wesentlichen Punkte erfassen. ';
$string['elc_de_re_b2_7'] = 'Ich kann ein Handbuch (z. B. zu einem Computerprogramm) rasch durchsuchen und für ein bestimmtes Problem die passenden Erklärungen und Hilfen finden und verstehen. ';
$string['elc_de_re_b2_8'] = 'Ich kann in einem erzählenden Text oder einem Theaterstück die Handlungsmotive der Personen und die Konsequenzen für den Handlungsablauf erkennen.';
$string['elc_de_re_c1_1'] = 'Ich kann längere, anspruchsvolle Texte verstehen und mündlich zusammenfassen. ';
$string['elc_de_re_c1_2'] = 'Ich kann ausführliche Berichte, Analysen und Kommentare lesen, in denen Zusammenhänge, Meinungen und Standpunkte erörtert werden. ';
$string['elc_de_re_c1_3'] = 'Ich kann hoch spezialisierten Texten aus dem eigenen Fachgebiet (z. B. Forschungsberichten) Informationen, Gedanken und Meinungen entnehmen. ';
$string['elc_de_re_c1_4'] = 'Ich kann längere komplexe Anleitungen und Anweisungen verstehen, z. B. zur Bedienung eines neuen Geräts, auch wenn diese nicht in Bezug zu meinem Sach- oder Interessengebiet stehen, sofern ich genug Zeit zum Lesen habe. ';
$string['elc_de_re_c1_5'] = 'Ich kann unter gelegentlicher Zuhilfenahme des Wörterbuchs jegliche Korrespondenz verstehen. ';
$string['elc_de_re_c1_6'] = 'Ich kann zeitgenössische literarische Texte fließend lesen. ';
$string['elc_de_re_c1_7'] = 'Ich kann in einem literarischen Text vom erzählten Geschehen abstrahieren und implizite Aussagen, Ideen und Zusammenhänge erfassen. ';
$string['elc_de_re_c1_8'] = 'Ich kann den sozialen, politischen oder geschichtlichen Hintergrund eines literarischen Werkes erkennen.';
$string['elc_de_re_c2_1'] = 'Ich kann Wortspiele erkennen und Texte richtig verstehen, deren eigentliche Bedeutung nicht in dem liegt, was explizit gesagt wird (z. B. Ironie, Satire). ';
$string['elc_de_re_c2_2'] = 'Ich kann Texte verstehen, die stark umgangssprachlich sind und zahlreiche idiomatische Ausdrücke (Redewendungen) oder Slang enthalten. ';
$string['elc_de_re_c2_3'] = 'Ich kann Handbücher, Verordnungen und Verträge verstehen, auch wenn mir das Gebiet nicht vertraut ist. ';
$string['elc_de_re_c2_4'] = 'Ich kann zeitgenössische und klassische literarische Texte verschiedener Gattungen lesen (Gedichte, Prosa, dramatische Werke). ';
$string['elc_de_re_c2_5'] = 'Ich kann Texte wie etwa literarische Kolumnen oder satirische Glossen lesen, in denen vieles indirekt gesagt wird, mehrdeutig ist und die versteckte Wertungen enthalten. ';
$string['elc_de_re_c2_6'] = 'Ich kann unterschiedlichste literarische Stilmittel (Wortspiele, Metaphern, literarische Motive, Symbolisierung, Konnotation, Mehrdeutigkeit) erkennen und ihre Funktion innerhalb des Textes einschätzen. ';
$string['elc_de_re_c2_7'] = 'Ich kann lange, komplexe, wissenschaftliche Texte im Detail verstehen, auch wenn diese nicht meinem eigenen Spezialgebiet angehören.';
$string['elc_de_si_a1_1'] = 'Ich kann jemanden vorstellen und einfache Gruß- und Abschiedsformeln gebrauchen. ';
$string['elc_de_si_a1_2'] = 'Ich kann einfache Fragen stellen und beantworten, einfache Aussagen machen oder auf einfache Aussagen von anderen reagieren, sofern es um ganz vertraute oder unmittelbar notwendige Dinge geht. ';
$string['elc_de_si_a1_3'] = 'Ich kann mich auf einfache Art verständigen, bin aber darauf angewiesen, dass die Gesprächspartnerin / der Gesprächspartner bereit ist, etwas langsamer zu wiederholen oder anders zu sagen, und mir dabei hilft zu formulieren, was ich sagen möchte. ';
$string['elc_de_si_a1_4'] = 'Ich kann einfache Einkäufe machen, wenn es möglich ist, durch Zeigen oder Gesten zu verdeutlichen, was ich meine. ';
$string['elc_de_si_a1_5'] = 'Ich komme mit Zahlen, Mengenangaben, Preisen und Uhrzeiten zurecht ';
$string['elc_de_si_a1_6'] = 'Ich kann andere um etwas bitten und anderen etwas geben. ';
$string['elc_de_si_a1_7'] = 'Ich kann Leuten Fragen zu ihrer Person stellen – z. B. wo sie wohnen, was für Leute sie kennen oder was für Dinge sie haben – und ich kann auf Fragen dieser Art Antwort geben, wenn die Fragen langsam und deutlich formuliert werden. ';
$string['elc_de_si_a1_8'] = 'Ich kann Angaben zur Zeit machen mit Hilfe von Wendungen wie „nächste Woche“, „letzten Freitag“, „im November“, „um drei Uhr“.';
$string['elc_de_si_a2_1'] = 'Ich kann in Geschäften, auf der Post oder Bank einfache Erledigungen machen. ';
$string['elc_de_si_a2_2'] = 'Ich kann öffentliche Verkehrsmittel wie Bus, Zug, Taxi benutzen, um einfache Auskünfte bitten und Billette kaufen. ';
$string['elc_de_si_a2_3'] = 'Ich kann mir einfache Informationen für eine Reise beschaffen. ';
$string['elc_de_si_a2_4'] = 'Ich kann etwas zum Essen und Trinken bestellen. ';
$string['elc_de_si_a2_5'] = 'Ich kann einfache Einkäufe machen, sagen, was ich suche, und nach dem Preis fragen. ';
$string['elc_de_si_a2_6'] = 'Ich kann nach dem Weg fragen und mit einer Karte oder einem Stadtplan den Weg erklären. ';
$string['elc_de_si_a2_7'] = 'Ich kann jemanden grüssen, fragen, wie es ihr/ihm geht, und auf Neuigkeiten reagieren. ';
$string['elc_de_si_a2_8'] = 'Ich kann jemanden einladen und reagieren, wenn mich jemand einlädt. ';
$string['elc_de_si_a2_9'] = 'Ich kann um Entschuldigung bitten und auf eine Entschuldigung reagieren. ';
$string['elc_de_si_a2_10'] = 'Ich kann sagen, was ich gerne habe und was nicht. ';
$string['elc_de_si_a2_11'] = 'Ich kann mit anderen besprechen, was man tun oder wohin man gehen will, und kann vereinbaren, wann und wo man sich trifft. ';
$string['elc_de_si_a2_12'] = 'Ich kann fragen, was jemand bei der Arbeit und in der Freizeit macht, und ich kann entsprechende Fragen von anderen beantworten.';
$string['elc_de_si_b1_1'] = 'Ich kann ein einfaches direktes Gespräch über vertraute oder mich persönlich interessierende Themen beginnen, in Gang halten und beenden. ';
$string['elc_de_si_b1_2'] = 'Ich kann mich an einem Gespräch oder einer Diskussion beteiligen, aber man versteht mich möglicherweise nicht immer, wenn ich versuche zu sagen, was ich eigentlich sagen möchte. ';
$string['elc_de_si_b1_3'] = 'Ich kann die meisten Situationen bewältigen, die sich beim Buchen einer Reise oder auf der Reise selbst ergeben. ';
$string['elc_de_si_b1_4'] = 'Ich kann Gefühle wie Überraschung, Freude, Trauer, Interesse und Gleichgültigkeit ausdrücken und auf entsprechende Gefühlsäußerungen anderer reagieren. ';
$string['elc_de_si_b1_5'] = 'Ich kann in Gesprächen mit Bekannten und Freunden persönliche Ansichten und Meinungen austauschen. ';
$string['elc_de_si_b1_6'] = 'Ich kann Zustimmung äußern und höflich widersprechen. ';
$string['elc_de_si_b1_7'] = 'Ich kann in informellen Situationen mit Kollegen/Mitstudierenden über Fachinhalte sprechen. ';
$string['elc_de_si_b1_8'] = 'Ich kann die meisten Gesprächssituationen bewältigen, die mit der Organisation des Studiums zusammenhängen, normalerweise auch am Telefon.';
$string['elc_de_si_b2_1'] = 'Ich kann ein Gespräch auf natürliche Art beginnen, in Gang halten und beenden und wirksam zwischen der Rolle als Sprecher und Hörer wechseln. ';
$string['elc_de_si_b2_2'] = 'Ich kann in meinem Fach- und Interessengebiet größere Mengen von Sachinformationen austauschen. ';
$string['elc_de_si_b2_3'] = 'Ich kann Gefühle unterschiedlicher Intensität zum Ausdruck bringen und hervorheben, was für mich persönlich an Ereignissen oder Erfahrungen bedeutsam ist. ';
$string['elc_de_si_b2_4'] = 'Ich kann mich aktiv an längeren Gesprächen über die meisten Themen von allgemeinem Interesse beteiligen. ';
$string['elc_de_si_b2_5'] = 'Ich kann in Diskussionen meine Ansichten durch Erklärungen, Argumente und Kommentare begründen und verteidigen. ';
$string['elc_de_si_b2_6'] = 'Ich kann zum Fortgang eines Gesprächs auf einem mir vertrauten Gebiet beitragen, indem ich zum Beispiel bestätige, dass ich verstehe, oder indem ich andere auffordere, etwas zu sagen. ';
$string['elc_de_si_b2_7'] = 'Ich kann ein vorbereitetes Interviewgespräch führen, dabei nachfragen, ob ich das Gesagte richtig verstanden habe, und auf interessante Antworten näher eingehen. ';
$string['elc_de_si_b2_8'] = 'Ich kann mich innerhalb und außerhalb von Lehrveranstaltungen aktiv an Gesprächen über fachliche oder kulturelle Themen beteiligen. ';
$string['elc_de_si_b2_9'] = 'Ich kann effizient Probleme lösen, die mit der Organisation des Studiums zusammenhängen, z.B. in Kontakten mit Dozierenden und der Verwaltung.';
$string['elc_de_si_c1_1'] = 'Ich kann auch in lebhaften Gesprächen unter Muttersprachlerinnen / Muttersprachlern gut mithalten. ';
$string['elc_de_si_c1_2'] = 'Ich kann flüssig, korrekt und wirkungsvoll über ein sehr breites Spektrum von Themen allgemeiner, beruflicher oder wissenschaftlicher Art sprechen. ';
$string['elc_de_si_c1_3'] = 'Ich kann die Sprache in Gesellschaft wirksam und flexibel gebrauchen, auch um Gefühle auszudrücken, Anspielungen zu machen oder zu scherzen. ';
$string['elc_de_si_c1_4'] = 'Ich kann in Diskussionen meine Gedanken und Meinungen präzise und klar formuliert ausdrücken, überzeugend argumentieren und wirksam auf komplexe Argumentation anderer reagieren.';
$string['elc_de_si_c2_1'] = 'Ich kann mich mühelos an allen Gesprächen und Diskussionen mit Muttersprachlerinnen / Muttersprachlern beteiligen. ';
$string['elc_de_si_c2_2'] = 'Ich beherrsche idiomatische und umgangssprachliche Wendungen sowie Fachjargon in meinem Spezialgebiet gut und bin mir der jeweiligen Konnotationen bewusst. Ich kann auch feinere Bedeutungsnuancen deutlich machen. ';
$string['elc_de_si_c2_3'] = 'Ich kann mich in formellen Diskussionen über komplexe Themen behaupten, indem ich klar und überzeugend argumentiere; dabei bin ich gegenüber Muttersprachlern nicht im Nachteil. ';
$string['elc_de_si_c2_4'] = 'Ich kann mit schwierigen und auch unfreundlichen Fragen umgehen, die mir im Anschluss an ein Referat oder eine Präsentation gestellt werden. ';
$string['elc_de_si_c2_5'] = 'Ich kann Informationen aus verschiedenen Quellen mündlich zusammenfassen und dabei die enthaltenen Argumente und Sachverhalte in einer klaren zusammenhängenden Darstellung wiedergeben. ';
$string['elc_de_si_c2_6'] = 'Ich kann Gedanken und Standpunkte sehr flexibel vortragen und dabei etwas hervorheben, differenzieren und Mehrdeutigkeit beseitigen. ';
$string['elc_de_si_c2_7'] = 'Ich kann sicher und gut verständlich einem Publikum ein komplexes Thema vortragen, mit dem es nicht vertraut ist, und dabei die Rede flexibel den Bedürfnissen des Publikums anpassen und entsprechend strukturieren.';
$string['elc_de_sp_a1_1'] = 'Ich kann Angaben zu meiner Person machen (z. B. Adresse, Telefonnummer, Alter, Herkunftsland, Familie, Hobbys). ';
$string['elc_de_sp_a1_2'] = 'Ich kann beschreiben, wo ich wohne.';
$string['elc_de_sp_a2_1'] = 'Ich kann mich selbst, meine Familie und andere Personen beschreiben. ';
$string['elc_de_sp_a2_2'] = 'Ich kann beschreiben, wo ich wohne. ';
$string['elc_de_sp_a2_3'] = 'Ich kann kurz und einfach über ein Ereignis berichten. ';
$string['elc_de_sp_a2_4'] = 'Ich kann meine Ausbildung und meine gegenwärtige oder letzte berufliche Tätigkeit beschreiben. ';
$string['elc_de_sp_a2_5'] = 'Ich kann in einfacher Form über meine Hobbys und Interessen berichten. ';
$string['elc_de_sp_a2_6'] = 'Ich kann über vergangene Aktivitäten und persönliche Erfahrungen berichten (z. B. das letzte Wochenende oder meine letzten Ferien).';
$string['elc_de_sp_b1_1'] = 'Ich kann eine Geschichte erzählen. ';
$string['elc_de_sp_b1_2'] = 'Ich kann detailliert über Erfahrungen berichten und dabei meine Gefühle und Reaktionen beschreiben. ';
$string['elc_de_sp_b1_3'] = 'Ich kann Träume, Hoffnungen, Ziele beschreiben. ';
$string['elc_de_sp_b1_4'] = 'Ich kann meine Absichten, Pläne oder Handlungen erklären und begründen. ';
$string['elc_de_sp_b1_5'] = 'Ich kann die Handlung eines Films oder eines Buchs wiedergeben und meine Reaktionen beschreiben. ';
$string['elc_de_sp_b1_6'] = 'Ich kann kurze Passagen aus schriftlichen Texten auf einfache Art und Weise mündlich wiedergeben, indem ich den Wortlaut und die Anordnung des Originaltextes benutze. ';
$string['elc_de_sp_b1_7'] = 'Ich kann zu verschiedenen vertrauten Themen meines Interessen- oder Fachbereichs unkomplizierte Beschreibungen oder Berichte geben. ';
$string['elc_de_sp_b1_8'] = 'Ich kann eine vorbereitete, unkomplizierte Präsentation zu einem vertrauten Thema aus meinem Fachgebiet klar und präzise genug vortragen, dass man ihr meist mühelos folgen kann und die Hauptpunkte verstanden werden.';
$string['elc_de_sp_b2_1'] = 'Ich kann zu sehr vielen Themen meines Interessengebiets klare und detaillierte Beschreibungen und Berichte geben. ';
$string['elc_de_sp_b2_2'] = 'Ich kann kurze Auszüge aus Nachrichten, Interviews oder Reportagen, welche Stellungnahmen, Erörterungen und Diskussionen enthalten, verstehen und mündlich zusammenfassen. ';
$string['elc_de_sp_b2_3'] = 'Ich kann die Handlung und die Abfolge der Ereignisse in einem Auszug aus einem Film oder Theaterstück verstehen und mündlich zusammenfassen. ';
$string['elc_de_sp_b2_4'] = 'Ich kann eine Argumentation logisch aufbauen und die Gedanken verknüpfen. ';
$string['elc_de_sp_b2_5'] = 'Ich kann einen Standpunkt zu einem Problem erklären und Vor- und Nachteile zu verschiedenen Möglichkeiten angeben. ';
$string['elc_de_sp_b2_6'] = 'Ich kann Vermutungen über Ursachen und Konsequenzen anstellen und über hypothetische Situationen sprechen. ';
$string['elc_de_sp_b2_7'] = 'Ich kann im eigenen Fach frei oder nach Stichworten einen Kurzvortrag halten.';
$string['elc_de_sp_b2_8'] = 'Ich kann aus verschiedenen schriftlichen Quellen stammende Informationen und Argumente zusammenfassen und mündlich wiedergeben.';
$string['elc_de_sp_c1_1'] = 'Ich kann komplexe Sachverhalte klar und detailliert darstellen. ';
$string['elc_de_sp_c1_2'] = 'Ich kann lange, anspruchsvolle Texte mündlich zusammenfassen. ';
$string['elc_de_sp_c1_3'] = 'Ich kann mündlich etwas ausführlich darstellen oder berichten, dabei Themenpunkte miteinander verbinden, einzelne Aspekte besonders ausführen und meinen Beitrag angemessen abschließen. ';
$string['elc_de_sp_c1_4'] = 'Ich kann in meinem Fach- und Interessengebiet ein klar gegliedertes Referat halten, dabei wenn nötig vom vorbereiteten Text abweichen und spontan auf Fragen von Zuhörenden eingehen.';
$string['elc_de_sp_c2_1'] = 'Ich kann Informationen aus verschiedenen Quellen mündlich zusammenfassen und dabei die enthaltenen Argumente und Sachverhalte in einer klaren zusammenhängenden Darstellung wiedergeben. ';
$string['elc_de_sp_c2_2'] = 'Ich kann Gedanken und Standpunkte sehr flexibel vortragen und dabei etwas hervorheben, differenzieren und Mehrdeutigkeit beseitigen. ';
$string['elc_de_sp_c2_3'] = 'Ich kann sicher und gut verständlich einem Publikum ein komplexes Thema vortragen, mit dem es nicht vertraut ist, und dabei die Rede flexibel den Bedürfnissen des Publikums anpassen und entsprechend strukturieren.';
$string['elc_de_wr_a1_1'] = 'Ich kann auf einem Fragebogen Angaben zu meiner Person machen (Beruf, Alter, Wohnort, Hobbys). ';
$string['elc_de_wr_a1_2'] = 'Ich kann eine Glückwunschkarte schreiben, zum Beispiel zum Geburtstag. ';
$string['elc_de_wr_a1_3'] = 'Ich kann eine einfache Postkarte (z. B. mit Feriengrüßen) schreiben. ';
$string['elc_de_wr_a1_4'] = 'Ich kann einen Notizzettel schreiben, um jemanden zu informieren, wo ich bin oder wo wir uns treffen. ';
$string['elc_de_wr_a1_5'] = 'Ich kann in einfachen Sätzen über mich schreiben, z. B. wo ich wohne und was ich mache.';
$string['elc_de_wr_a2_1'] = 'Ich kann eine kurze, einfache Notiz oder Mitteilung schreiben. ';
$string['elc_de_wr_a2_2'] = 'Ich kann in einfachen Sätzen ein Ereignis beschreiben und sagen, was wann wo stattgefunden hat (z. B. ein Fest, ein Unfall). ';
$string['elc_de_wr_a2_3'] = 'Ich kann in einfachen Sätzen und Ausdrücken über Dinge aus meinem Alltag schreiben (Leute, Orte, Arbeit, Schule, Familie, Hobbys). ';
$string['elc_de_wr_a2_4'] = 'Ich kann in Fragebögen über meine Ausbildung, meine Arbeit, meine Interessen und Spezialgebiete Auskunft geben. ';
$string['elc_de_wr_a2_5'] = 'Ich kann mich in einem Brief mit einfachen Sätzen und Ausdrücken kurz vorstellen (Familie, Schule, Arbeit, Hobbys). ';
$string['elc_de_wr_a2_6'] = 'Ich kann einen kurzen Brief schreiben und darin einfache Formeln für Anrede, Gruß, Dank und Bitte verwenden. ';
$string['elc_de_wr_a2_7'] = 'Ich kann einfache Sätze schreiben und sie mit Wörtern wie „und“, „aber“, „weil“, „denn“ verbinden. ';
$string['elc_de_wr_a2_8'] = 'Ich kann die wichtigsten verknüpfenden Wörter verwenden, um die zeitliche Abfolge von Ereignissen kenntlich zu machen („zuerst“, „dann“, „nachher“, „später“).';
$string['elc_de_wr_b1_1'] = 'Ich kann einen einfachen zusammenhängenden Text über verschiedene Themen meines Interessengebietes schreiben und persönliche Ansichten und Meinungen ausdrücken. ';
$string['elc_de_wr_b1_2'] = 'Ich kann z. B. für eine Klubzeitung einen einfachen Text über Erfahrungen oder Ereignisse schreiben, z. B. über eine Reise. ';
$string['elc_de_wr_b1_3'] = 'Ich kann persönliche Briefe oder E-Mails an Freunde oder Bekannte schreiben, nach Neuigkeiten fragen oder Neuigkeiten mitteilen und von Ereignissen erzählen. ';
$string['elc_de_wr_b1_4'] = 'Ich kann in einem persönlichen Brief die Handlung eines Films oder Buchs erzählen oder von einem Konzert berichten. ';
$string['elc_de_wr_b1_5'] = 'Ich kann in einem Brief Gefühle wie Trauer, Freude, Interesse, Bedauern und mein Mitgefühl ausdrücken. ';
$string['elc_de_wr_b1_6'] = 'Ich kann auf Anzeigen und Inserate schriftlich reagieren und zusätzliche oder genauere Informationen über die Produkte verlangen (z. B. über ein Auto oder einen Schulungskurs). ';
$string['elc_de_wr_b1_7'] = 'Ich kann Bekannten oder Mitarbeiterinnen und Mitarbeitern per Fax, E-Mail oder Laufzettel kurze einfache Sachinformationen mitteilen oder nach solchen fragen. ';
$string['elc_de_wr_b1_8'] = 'Ich kann einen tabellarischen Lebenslauf schreiben. ';
$string['elc_de_wr_b1_9'] = 'Ich kann in meinem Fachgebiet den Verlauf eines wissenschaftlichen Experiments in Stichworten festhalten. ';
$string['elc_de_wr_b1_10'] = 'Ich kann in meinem Fachgebiet einfache Texte verfassen und dabei wichtige Fachbegriffe richtig gebrauchen.';
$string['elc_de_wr_b2_1'] = 'Ich kann klare und detaillierte Texte über unterschiedliche Themen schreiben, die mit meinem Interessengebiet zu tun haben, sei in Form von Aufsätzen, Berichten oder Referaten. ';
$string['elc_de_wr_b2_2'] = 'Ich kann eine Zusammenfassung zu einem Artikel über ein Thema von allgemeinem Interesse schreiben. ';
$string['elc_de_wr_b2_3'] = 'Ich kann Informationen aus verschiedenen Quellen und Medien schriftlich zusammenfassen. ';
$string['elc_de_wr_b2_4'] = 'Ich kann in einem Aufsatz oder Bericht etwas erörtern und dabei entscheidende Punkte hervorheben und Einzelheiten anführen, welche die Argumentation stützen. ';
$string['elc_de_wr_b2_5'] = 'Ich kann ausführlich und gut lesbar über Ereignisse und reale oder fiktive Erlebnisse schreiben. ';
$string['elc_de_wr_b2_6'] = 'Ich kann eine kurze Besprechung über einen Film oder ein Buch schreiben. ';
$string['elc_de_wr_b2_7'] = 'Ich kann in privaten Briefen oder E-Mails verschiedene Einstellungen und Gefühle ausdrücken und ich kann von den Neuigkeiten des Tages erzählen und dabei deutlich machen, was für mich an einem Ereignis wichtig ist. ';
$string['elc_de_wr_b2_8'] = 'Ich kann selbstständig Seminararbeiten schreiben, muss sie aber von jemandem auf sprachliche Korrektheit und Angemessenheit hin überprüfen lassen. ';
$string['elc_de_wr_b2_9'] = 'Ich kann wissenschaftliche Texte aus meinem Fachgebiet für den späteren Gebrauch schriftlich zusammenfassen.';
$string['elc_de_wr_c1_1'] = 'Ich kann mich schriftlich zu unterschiedlichsten Themen allgemeiner oder beruflicher Art klar und gut lesbar äußern. ';
$string['elc_de_wr_c1_2'] = 'Ich kann z. B. in einem Aufsatz oder Arbeitsbericht ein komplexes Thema klar und gut strukturiert darlegen und die wichtigsten Punkte hervorheben. ';
$string['elc_de_wr_c1_3'] = 'Ich kann in einem Kommentar zu einem Thema oder einem Ereignis verschiedene Standpunkte darstellen, dabei die Hauptgedanken hervorheben und meine Argumentation durch ausführliche Beispiele verdeutlichen. ';
$string['elc_de_wr_c1_4'] = 'Ich kann Informationen aus verschiedenen Quellen zusammentragen und in zusammenhängender Form schriftlich zusammenfassen. ';
$string['elc_de_wr_c1_5'] = 'Ich kann in persönlichen Briefen ausführlich Erfahrungen, Gefühle und Geschehnisse beschreiben. ';
$string['elc_de_wr_c1_6'] = 'Ich kann formal korrekte Briefe schreiben, zum Beispiel einen Beschwerdebrief oder eine Stellungnahme für oder gegen etwas. ';
$string['elc_de_wr_c1_7'] = 'Ich kann Texte schreiben, die weitgehend korrekt sind, und meinen Wortschatz und Stil je nach Adressatin / Adressat, Textsorte und Thema variieren. ';
$string['elc_de_wr_c1_8'] = 'Ich kann in meinen schriftlichen Texten den Stil wählen, der für die jeweiligen Leser angemessen ist. ';
$string['elc_de_wr_c1_9'] = 'Ich verwende in meinen Texten ohne größere Probleme die Terminologie und Idiomatik meines Fachgebiets.';
$string['elc_de_wr_c2_1'] = 'Ich kann gut strukturierte und gut lesbare Berichte und Artikel über komplexe Themen schreiben. ';
$string['elc_de_wr_c2_2'] = 'Ich kann in einem Bericht oder Essay ein Thema, das ich recherchiert habe, umfassend darstellen, die Meinungen anderer zusammenfassen, Detailinformationen und Fakten aufführen und beurteilen. ';
$string['elc_de_wr_c2_3'] = 'Ich kann eine schriftliche Stellungnahme zu einem Arbeitspapier oder einem Projekt schreiben, sie klar gliedern und darin meine Meinung begründen. ';
$string['elc_de_wr_c2_4'] = 'Ich kann zu kulturellen Ereignissen (Film, Musik, Theater, Literatur, Radio, Fernsehen) eine kritische Stellungnahme schreiben. ';
$string['elc_de_wr_c2_5'] = 'Ich kann Zusammenfassungen von Sachtexten und literarischen Werken schreiben. ';
$string['elc_de_wr_c2_6'] = 'Ich kann über Erfahrungen Geschichten schreiben, die in einem klaren und flüssigen, dem Genre entsprechenden Stil abgefasst sind. ';
$string['elc_de_wr_c2_7'] = 'Ich kann klare und gut strukturierte formelle Briefe auch komplexerer Art in passendem Stil schreiben, z. B. Anträge, Eingaben, Offerten an Behörden, Vorgesetzte oder Geschäftskunden. ';
$string['elc_de_wr_c2_8'] = 'Ich kann mich in Briefen oder E-Mails bewusst ironisch, mehrdeutig oder humorvoll ausdrücken. ';
$string['elc_de_wr_c2_9'] = 'Ich kann mit Blick auf eine Veröffentlichung wissenschaftliche Texte in meinem Fachgebiet schreiben, die korrekt und stilistisch weitgehend angemessen sind. ';
$string['elc_de_wr_c2_10'] = 'Ich kann zu wissenschaftlichen Veröffentlichungen in meinem Fachgebiet eine zur Veröffentlichung bestimmte kritische Stellungnahme (z.B. Rezension) schreiben. ';
$string['elc_de_wr_c2_11'] = 'Ich kann im Verlauf eines Seminars, Tutoriums oder Kurses genaue und vollständige Aufzeichnungen machen. ';
$string['elc_de_wr_c2_12'] = 'Ich kann Informationen aus verschiedenen Quellen zusammenfassen und die Argumente und berichteten Sachverhalte so wiedergeben, dass insgesamt eine kohärente Darstellung entsteht. ';
$string['elc_de_wr_c2_13'] = 'Ich kann Texte von Kollegen überarbeiten und grammatisch und stilistisch verbessern; dabei habe ich nur selten Unsicherheiten.';

/*
 * descriptors ELC English
 */
 
 //Listening
$string['elc_en_li_a1_1'] = 'I can understand when someone speaks very slowly to me and articulates carefully, with long pauses for me to assimilate meaning.';
$string['elc_en_li_a1_2'] = 'I can understand simple directions on how to get from X to Y, by foot or public transport.';
$string['elc_en_li_a1_3'] = 'I can understand questions and instructions addressed carefully and slowly to me and follow short, simple directions.';
$string['elc_en_li_a1_4'] = 'I can understand numbers, prices and times.';

$string['elc_en_li_a2_1'] = 'I can understand what is said clearly, slowly and directly to me in simple everyday conversation; it is possible to make me understand, if the speaker can take the trouble.';
$string['elc_en_li_a2_2'] = 'I can generally identify the topic of discussion around me when people speak slowly and clearly.';
$string['elc_en_li_a2_3'] = 'I can understand phrases, words and expressions related to areas of most immediate priority (e.g. very basic personal and family information, shopping, local area, employment).';
$string['elc_en_li_a2_4'] = 'I can grasp the main point in short, clear, simple messages and announcements.';
$string['elc_en_li_a2_5'] = 'I can understand the essential information in short recorded passages dealing with predictable everyday matters provided they are spoken slowly and clearly.';
$string['elc_en_li_a2_6'] = 'I can identify the main point of TV news items reporting events, accidents etc. when the visual supports the commentary.';

$string['elc_en_li_b1_1'] = 'I can follow clearly articulated speech directed at me in everyday conversation, though I sometimes have to ask for repetition of particular words and phrases.';
$string['elc_en_li_b1_2'] = 'I can generally follow the main points of extended discussion around me, provided speech is clearly articulated in standard dialect.';
$string['elc_en_li_b1_3'] = 'I can listen to a short narrative and form hypotheses about what will happen next.';
$string['elc_en_li_b1_4'] = 'I can understand the main points of radio news bulletins and simpler recorded material on topics of personal interest delivered relatively slowly and clearly.';
$string['elc_en_li_b1_5'] = 'I can grasp the main points in TV programmes on familiar topics when the delivery is relatively slow and clear.';
$string['elc_en_li_b1_6'] = 'I can understand simple technical information, such as operating instructions for everyday equipment.';
$string['elc_en_li_b1_7'] = 'I can understand the main points of a discussion on familiar matters within my own field (e.g., in a seminar, at a round table, or during a television discussion), provided that the participants speak clearly and use standard language.';
$string['elc_en_li_b1_8'] = 'I can take notes on the main points of a lecture which are precise enough for my own use at a later date, provided the topic is within my field of study and the talk is clear and well-structured.';

$string['elc_en_li_b2_1'] = 'I can understand in detail what is said to me in standard spoken language even in a noisy environment.';
$string['elc_en_li_b2_2'] = 'I can follow a lecture or talk within my own field, provided the subject matter is familiar and the presentation straightforward and clearly structured.';
$string['elc_en_li_b2_3'] = 'I can understand most radio documentaries delivered in standard language and can identify the speaker’s mood, tone etc.';
$string['elc_en_li_b2_4'] = 'I can understand TV documentaries, live interviews, talk shows, plays and the majority of films in standard dialect.';
$string['elc_en_li_b2_5'] = 'I can understand the main ideas of complex speech on both concrete and abstract topics delivered in a standard dialect, including technical discussions in my field of specialisation.';
$string['elc_en_li_b2_6'] = 'I can use a variety of strategies to achieve comprehension, including listening for main points and checking comprehension by using contextual clues.';
$string['elc_en_li_b2_7'] = 'I can understand a clearly structured lecture on a familiar topic and take notes on points that strike me as important, although I sometimes get stuck on words and therefore miss part of the information.';

$string['elc_en_li_c1_1'] = 'I can follow extended speech even when it is not clearly structured and when relationships are only implied and not signalled explicitly.';
$string['elc_en_li_c1_2'] = 'I can understand a wide range of idiomatic expressions and colloquialisms, appreciating shifts in style and register.';
$string['elc_en_li_c1_3'] = 'I can extract specific information from even poor quality, audibly distorted public announcements, e.g. in a station, sports stadium etc.';
$string['elc_en_li_c1_4'] = 'I can understand complex technical information, such as operating instructions, specifications for familiar products and services.';
$string['elc_en_li_c1_5'] = 'I can understand lectures, talks and reports in my field of professional or academic interest even when they are propositionally and linguistically complex.';
$string['elc_en_li_c1_6'] = 'I can, without too much effort, understand films which contain a considerable degree of slang and idiomatic usage.';
$string['elc_en_li_c1_7'] = 'I can understand radio and television programs in my field, even when they are demanding in content and linguistically complex.';
$string['elc_en_li_c1_8'] = 'I can understand in detail speech on abstract and complex topics of a specialist nature outside my own field, although on occasion I need to confirm details, especially when the accent is unfamiliar.';
$string['elc_en_li_c1_9'] = 'I can take detailed notes during a lecture on a familiar topic in my field of interest, recording the information so accurately and so closely to the original that they are also useful to other people.';

$string['elc_en_li_c2_1'] = 'I have no difficulty in understanding any kind of spoken language, whether live or broadcast, even when delivered at fast native speed, provided I have some time to become familiar with the accent.';
$string['elc_en_li_c2_2'] = 'I can follow specialised lectures and presentations that contain a high degree of colloquial expressions, regional usage, or unfamiliar terminology.';
$string['elc_en_li_c2_3'] = 'I notice, during a lecture or seminar, what is only implicitly said and alluded to and can take notes on this as well as what the speaker directly expresses.';

//Reading
$string['elc_en_re_a1_1'] = 'I can understand information about people (place of residence, age, etc.) in newspapers.';
$string['elc_en_re_a1_2'] = 'I can locate a concert or a film on calendars of public events or posters and identify where it takes place and at what time it starts.';
$string['elc_en_re_a1_3'] = 'I can understand a questionnaire (entry permit form, hotel registration form) well enough to give the most important information about myself (name, surname, date of birth, nationality).';
$string['elc_en_re_a1_4'] = 'I can understand words and phrases on signs encountered in everyday life (for instance ”station”, ”car park”, ”no parking”, ”no smoking”, ”keep left”.';
$string['elc_en_re_a1_5'] = 'I can understand the most important orders in a computer programme such as ”PRINT”, ”SAVE”, ”COPY”, etc.';
$string['elc_en_re_a1_6'] = 'I can follow short simple written directions (e.g. how to go from X to Y).';
$string['elc_en_re_a1_7'] = 'I can understand short simple messages on postcards, for example holiday greetings.';
$string['elc_en_re_a1_8'] = 'In everyday situations I can understand simple messages written by friends or colleagues, for example ”back at 4 o’clock”.';

$string['elc_en_re_a2_1'] = 'I can identify important information in news summaries or simple newspaper articles in which numbers and names play an important role and which are clearly structured and illustrated.';
$string['elc_en_re_a2_2'] = 'I can understand a simple personal letter in which the writer tells or asks me about aspects of everyday life.';
$string['elc_en_re_a2_3'] = 'I can understand simple written messages from friends or colleagues, for example saying when we should meet to play football or asking me to be at work early.';
$string['elc_en_re_a2_4'] = 'I can find the most important information on leisure time activities, exhibitions, etc. in information leaflets.';
$string['elc_en_re_a2_5'] = 'I can skim small advertisements in newspapers, locate the heading or column I want and identify the most important pieces of information (price and size of apartments, cars, computers).';
$string['elc_en_re_a2_6'] = 'I can understand simple user’s instructions for equipment (for example, a public telephone).';
$string['elc_en_re_a2_7'] = 'I can understand feedback messages or simple help indications in computer programmes.';
$string['elc_en_re_a2_8'] = 'I can understand short narratives about everyday things dealing with topics which are familiar to me if the text is written in simple language.';

$string['elc_en_re_b1_1'] = 'I can understand the main points in short newspaper articles about current and familiar topics.';
$string['elc_en_re_b1_2'] = 'I can guess the meaning of single unknown words from the context thus deducing the meaning of expressions if the topic is familiar.';
$string['elc_en_re_b1_3'] = 'I can skim short texts (for example news summaries) and find relevant facts and information (for example who has done what and where).';
$string['elc_en_re_b1_4'] = 'I can understand simple messages and standard letters (for example from businesses, clubs or authorities).';
$string['elc_en_re_b1_5'] = 'In private letters I can understand those parts dealing with events, feelings and wishes well enough to correspond regularly with a pen friend.';
$string['elc_en_re_b1_6'] = 'I can understand the plot of a clearly structured story and recognise what the most important episodes and events are and what is significant about them.';
$string['elc_en_re_b1_7'] = 'I can identify the main conclusions in clearly written argumentative texts.';
$string['elc_en_re_b1_8'] = 'I can read straightforward factual texts on subjects related to my field and interests at a satisfactory level of understanding.';
$string['elc_en_re_b1_9'] = 'I can scan longer texts in my field in order to locate desired information and also to gather information from different texts or parts of a text in order to complete a specific task.';

$string['elc_en_re_b2_1'] = 'I can rapidly grasp the content and the significance of news, articles and reports on topics connected with my interests or my job, and decide if a closer reading is worthwhile.';
$string['elc_en_re_b2_2'] = 'I can read and understand articles and reports on current problems in which the writers express specific attitudes and points of view.';
$string['elc_en_re_b2_3'] = 'I can understand in detail texts within my field of interest or the area of my academic or professional speciality.';
$string['elc_en_re_b2_4'] = 'I can understand specialised articles outside my own field if I can occasionally check with a dictionary.';
$string['elc_en_re_b2_5'] = 'I can read reviews dealing with the content and criticism of cultural topics (films, theatre, books, concerts) and summarise the main points.';
$string['elc_en_re_b2_6'] = 'I can read letters on topics within my areas of academic or professional speciality or interest and grasp the most important points.';
$string['elc_en_re_b2_7'] = 'I can quickly look through a manual (for example, for a computer programme) and find and understand the relevant explanations and advice for a specific problem.';
$string['elc_en_re_b2_8'] = 'I can understand, in a narrative or play, the motives for the characters’ actions and their consequences for the development of the plot.';

$string['elc_en_re_c1_1'] = 'I can understand fairly long demanding texts and summarise them orally.';
$string['elc_en_re_c1_2'] = 'I can read complex reports, analyses and commentaries where opinions, viewpoints and implications are discussed.';
$string['elc_en_re_c1_3'] = 'I can extract information, ideas and opinions from highly specialised texts in my own field, for example, research reports.';
$string['elc_en_re_c1_4'] = 'I can understand long complex instructions, for example, for the use of a new piece of equipment, even if these are not related to my job or field of interest, provided I have enough time to reread them.';
$string['elc_en_re_c1_5'] = 'I can read any correspondence with occasional use of a dictionary.';
$string['elc_en_re_c1_6'] = 'I can read contemporary literary texts with ease.';
$string['elc_en_re_c1_7'] = 'I can go beyond the concrete plot of a narrative and grasp implicit meanings, ideas, and connections.';
$string['elc_en_re_c1_8'] = 'I can recognise the social, political, or historical background of a literary work.';

$string['elc_en_re_c2_1'] = 'I can recognise puns and appreciate texts whose real meaning is not explicit (for example irony, satire).';
$string['elc_en_re_c2_2'] = 'I can understand texts written in a very colloquial style and containing many idiomatic expressions or slang.';
$string['elc_en_re_c2_3'] = 'I can understand manuals, regulations and contracts even within unfamiliar fields.';
$string['elc_en_re_c2_4'] = 'I can understand contemporary and classical literary texts of different genres (poetry, prose, drama).';
$string['elc_en_re_c2_5'] = 'I can read texts such as literary columns or satirical glosses where much is said in an indirect and ambiguous way and which contain hidden value judgements.';
$string['elc_en_re_c2_6'] = 'I can recognise different stylistic means (puns, metaphors, symbols, connotations, ambiguity) and appreciate and evaluate their function within the text.';
$string['elc_en_re_c2_7'] = 'I can understand in detail lengthy and complex scientific texts, whether or not they relate to my own field.';

//Spoken Interaction
$string['elc_en_si_a1_1'] = 'I can introduce somebody and use basic greeting and leave-taking expressions.';
$string['elc_en_si_a1_2'] = 'I can ask and answer simple questions, initiate and respond to simple statements in areas of immediate need or on very familiar topics.';
$string['elc_en_si_a1_3'] = 'I can make myself understood in a simple way but I am dependent on my partner being prepared to repeat more slowly and rephrase what I say and to help me to say what I want.';
$string['elc_en_si_a1_4'] = 'I can make simple purchases where pointing or other gestures can support what I say.';
$string['elc_en_si_a1_5'] = 'I can handle numbers, quantities, cost and time.';
$string['elc_en_si_a1_6'] = 'I can ask people for things and give people things.';
$string['elc_en_si_a1_7'] = 'I can ask people questions about where they live, people they know, things they have, etc. and answer such questions addressed to me provided they are articulated slowly and clearly.';
$string['elc_en_si_a1_8'] = 'I can indicate time by such phrases as ”next week”, ”last Friday”, ”in November”, ”three o clock”.';

$string['elc_en_si_a2_1'] = 'I can make simple transactions in shops, post offices or banks.';
$string['elc_en_si_a2_2'] = 'I can use public transport: buses, trains, and taxis, ask for basic information and buy tickets.';
$string['elc_en_si_a2_3'] = 'I can get simple information about travel.';
$string['elc_en_si_a2_4'] = 'I can order something to eat or drink.';
$string['elc_en_si_a2_5'] = 'I can make simple purchases by stating what I want and asking the price.';
$string['elc_en_si_a2_6'] = 'I can ask for and give directions referring to a map or plan.';
$string['elc_en_si_a2_7'] = 'I can ask how people are and react to news.';
$string['elc_en_si_a2_8'] = 'I can make and respond to invitations.';
$string['elc_en_si_a2_9'] = 'I can make and accept apologies.';
$string['elc_en_si_a2_10'] = 'I can say what I like and dislike.';
$string['elc_en_si_a2_11'] = 'I can discuss with other people what to do, where to go and make arrangements to meet.';
$string['elc_en_si_a2_12'] = 'I can ask people questions about what they do at work and in free time, and answer such questions addressed to me.';

$string['elc_en_si_b1_1'] = 'I can start, maintain and close simple face-to-face conversation on topics that are familiar or of personal interest.';
$string['elc_en_si_b1_2'] = 'I can maintain a conversation or discussion but may sometimes be difficult to follow when trying to say exactly what I would like to.';
$string['elc_en_si_b1_3'] = 'I can deal with most situations likely to arise when making travel arrangements through an agent or when actually travelling.';
$string['elc_en_si_b1_4'] = 'I can express and respond to feelings such as surprise, happiness, sadness, interest and indifference. ';
$string['elc_en_si_b1_5'] = 'I can give or seek personal views and opinions in an informal discussion with friends.';
$string['elc_en_si_b1_6'] = 'I can agree and disagree politely.';
$string['elc_en_si_b1_7'] = 'I can speak about topics in my field in informal situations with colleagues or fellow students.';
$string['elc_en_si_b1_8'] = 'I can manage most discussions involved in the organisation of my studies, either face to face or by telephone.';

$string['elc_en_si_b2_1'] = 'I can initiate, maintain and end discourse naturally with effective turn-taking.';
$string['elc_en_si_b2_2'] = 'I can exchange considerable quantities of detailed factual information on matters within my fields of interest.';
$string['elc_en_si_b2_3'] = 'I can convey degrees of emotion and highlight the personal significance of events and experiences.';
$string['elc_en_si_b2_4'] = 'I can engage in extended conversation in a clearly participatory fashion on most general topics.';
$string['elc_en_si_b2_5'] = 'I can account for and sustain my opinions in discussion by providing relevant explanations, arguments and comments.';
$string['elc_en_si_b2_6'] = 'I can contribute to a discussion on familiar topics by confirming comprehension, inviting others in, etc.';
$string['elc_en_si_b2_7'] = 'I can carry out a prepared interview, checking and confirming information, following up interesting replies.';
$string['elc_en_si_b2_8'] = 'I can actively participate in conversations on specialised or cultural topics, whether during or outside of courses.';
$string['elc_en_si_b2_9'] = 'I can efficiently solve problems arising from the organisation of my studies, for example, with teachers and the administration.';

$string['elc_en_si_c1_1'] = 'I can keep up with an animated conversation between native speakers.';
$string['elc_en_si_c1_2'] = 'I can use the language fluently, accurately, and effectively on a wide range of general, professional, or academic topics.';
$string['elc_en_si_c1_3'] = 'I can use language flexibly and effectively for social purposes, including emotional, allusive and joking usage.';
$string['elc_en_si_c1_4'] = 'I can express my ideas and opinions clearly and precisely and can present and respond to complex lines of reasoning convincingly.';

$string['elc_en_si_c2_1'] = 'I can take part effortlessly in all conversations and discussions with native speakers.';
$string['elc_en_si_c2_2'] = 'I have a good command of idiomatic expressions and colloquialisms as well as the specialised language of my field, with connotative levels of meaning. I can also convey finer shades of meaning.';
$string['elc_en_si_c2_3'] = 'I can hold my own in formal discussions of complex issues, arguing articulately and persuasively and without being at a disadvantage compared with native speakers.';
$string['elc_en_si_c2_4'] = 'I can handle difficult and even hostile questioning after a speech or a presentation.';
//$string['elc_en_si_c2_5'] = 'Ich kann Informationen aus verschiedenen Quellen mündlich zusammenfassen und dabei die enthaltenen Argumente und Sachverhalte in einer klaren zusammenhängenden Darstellung wiedergeben. ';
//$string['elc_en_si_c2_6'] = 'Ich kann Gedanken und Standpunkte sehr flexibel vortragen und dabei etwas hervorheben, differenzieren und Mehrdeutigkeit beseitigen. ';
//$string['elc_en_si_c2_7'] = 'Ich kann sicher und gut verständlich einem Publikum ein komplexes Thema vortragen, mit dem es nicht vertraut ist, und dabei die Rede flexibel den Bedürfnissen des Publikums anpassen und entsprechend strukturieren.';
$string['elc_en_si_c2_5'] = ' ';
$string['elc_en_si_c2_6'] = ' ';
$string['elc_en_si_c2_7'] = ' ';

//Spoken Production
$string['elc_en_sp_a1_1'] = 'I can give personal information (address, telephone number, nationality, age, family, and hobbies). ';
$string['elc_en_sp_a1_2'] = 'I can describe where I live.';

$string['elc_en_sp_a2_1'] = 'I can describe myself, my family and other people.';
$string['elc_en_sp_a2_2'] = 'I can describe where I live.';
$string['elc_en_sp_a2_3'] = 'I can give short, basic descriptions of events.';
$string['elc_en_sp_a2_4'] = 'I can describe my educational background, my present or most recent job.';
$string['elc_en_sp_a2_5'] = 'I can describe my hobbies and interests in a simple way.';
$string['elc_en_sp_a2_6'] = 'I can describe past activities and personal experiences (e.g. the last weekend, my last holiday).';

$string['elc_en_sp_b1_1'] = 'I can narrate a story.';
$string['elc_en_sp_b1_2'] = 'I can give detailed accounts of experiences, describing feelings and reactions.';
$string['elc_en_sp_b1_3'] = 'I can describe dreams, hopes and ambitions.';
$string['elc_en_sp_b1_4'] = 'I can explain and give reasons for my plans, intentions and actions.';
$string['elc_en_sp_b1_5'] = 'I can relate the plot of a book or film and describe my reactions.';
$string['elc_en_sp_b1_6'] = 'I can paraphrase short written passages orally in a simple fashion, using the original text wording and ordering.';
$string['elc_en_sp_b1_7'] = 'I can give straightforward descriptions on a variety of familiar subjects related to my own fields of interest or study.';
$string['elc_en_sp_b1_8'] = 'I can give a simple, prepared presentation on a familiar topic within my field that is clear and precise enough to be followed without difficulty most of the time and in which the main points can be understood.';

$string['elc_en_sp_b2_1'] = 'I can give clear, detailed descriptions on a wide range of subjects related to my fields of interest.';
$string['elc_en_sp_b2_2'] = 'I can understand and summarise orally short extracts from news items, interviews or documentaries containing opinions, argument and discussion.';
$string['elc_en_sp_b2_3'] = 'I can understand and summarise orally the plot and sequence of events in an extract from a film or play.';
$string['elc_en_sp_b2_4'] = 'I can construct a chain of reasoned argument, linking my ideas logically.';
$string['elc_en_sp_b2_5'] = 'I can explain a viewpoint on a topical issue giving the advantages and disadvantages of various options.';
$string['elc_en_sp_b2_6'] = 'I can speculate about causes, consequences, and hypothetical situations.';
$string['elc_en_sp_b2_7'] = 'I can give a short talk in my field, either without notes or using keywords.';
$string['elc_en_sp_b2_8'] = 'I can summarise information and arguments from various written sources and reproduce them orally.';

$string['elc_en_sp_c1_1'] = 'I can give clear, detailed descriptions of complex subjects.';
$string['elc_en_sp_c1_2'] = 'I can orally summarise long, demanding texts.';
$string['elc_en_sp_c1_3'] = 'I can give an extended description or account of something, integrating themes, developing particular points and concluding appropriately.';
$string['elc_en_sp_c1_4'] = 'I can give a clearly developed presentation on a subject in my fields of personal or professional interest, departing when necessary from the prepared text and spontaneously following up points raised by members of the audience.';

$string['elc_en_sp_c2_1'] = 'I can summarise orally information from different sources, reconstructing arguments and accounts in a coherent presentation.';
$string['elc_en_sp_c2_2'] = 'I can present ideas and viewpoints in a very flexible manner in order to give emphasis, to differentiate, and to avoid ambiguity.';
$string['elc_en_sp_c2_3'] = 'I can present a complex topic confidently and articulately to an audience unfamiliar with it , structuring and adapting the talk flexibly to meet the audience\'s needs.';

// Ergänzen "Strategies"

// Ergänzen "Language Quality"

//Writing
$string['elc_en_wr_a1_1'] = 'I can fill in a questionnaire with my personal details (job, age, address, hobbies).';
$string['elc_en_wr_a1_2'] = 'I can write a greeting card, for instance a birthday card.';
$string['elc_en_wr_a1_3'] = 'I can write a simple postcard (for example with holiday greetings).';
$string['elc_en_wr_a1_4'] = 'I can write a note to tell somebody where I am or where we are to meet.';
$string['elc_en_wr_a1_5'] = 'I can write sentences and simple phrases about myself, for example where I live and what I do.';

$string['elc_en_wr_a2_1'] = 'I can write short, simple notes and messages.';
$string['elc_en_wr_a2_2'] = 'I can describe an event in simple sentences and report what happened when and where (for example a party or an accident).';
$string['elc_en_wr_a2_3'] = 'I can write about aspects of my everyday life in simple phrases and sentences (people, places, job, school, family, hobbies).';
$string['elc_en_wr_a2_4'] = 'I can fill in a questionnaire giving an account of my educational background, my job, my interests and my specific skills.';
$string['elc_en_wr_a2_5'] = 'I can briefly introduce myself in a letter with simple phrases and sentences (family, school, job, hobbies).';
$string['elc_en_wr_a2_6'] = 'I can write a short letter using simple expressions for greeting, addressing, asking or thanking somebody.';
$string['elc_en_wr_a2_7'] = 'I can write simple sentences, connecting them with words such as “and”, “but”, “because”.';
$string['elc_en_wr_a2_8'] = 'I can use the most important connecting words to indicate the chronological order of events (first, then, after, later).';

$string['elc_en_wr_b1_1'] = 'I can write simple connected texts on a range of topics within my field of interest and can express personal views and opinions.';
$string['elc_en_wr_b1_2'] = 'I can write simple texts about experiences or events, for example about a trip, for a school newspaper or a club newsletter.';
$string['elc_en_wr_b1_3'] = 'I can write personal letters to friends or acquaintances asking for or giving them news and narrating events. ';
$string['elc_en_wr_b1_4'] = 'I can describe in a personal letter the plot of a film or a book or give an account of a concert.';
$string['elc_en_wr_b1_5'] = 'In a letter, I can express feelings such as grief, happiness, interest, regret and sympathy.';
$string['elc_en_wr_b1_6'] = 'I can reply in written form to advertisements and ask for more complete or more specific information about products (for example a car or an academic course).';
$string['elc_en_wr_b1_7'] = 'I can convey – via fax, e-mail or a circular – short simple factual information to friends or colleagues or ask for information in such a way.';
$string['elc_en_wr_b1_8'] = 'I can write my CV in summary form.';
$string['elc_en_wr_b1_9'] = 'I can record the course of a scientific experiment in keywords.';
$string['elc_en_wr_b1_10'] = 'I can write simple texts in my field, correctly using the most important specialised terms.';

$string['elc_en_wr_b2_1'] = 'I can write clear and detailed texts (compositions, reports or texts of presentations) on various topics related to my field of interest.';
$string['elc_en_wr_b2_2'] = 'I can write summaries of articles on topics of general interest.';
$string['elc_en_wr_b2_3'] = 'I can summarise information from different sources and media.';
$string['elc_en_wr_b2_4'] = 'I can develop an argument systematically in a composition or report, emphasising decisive points and including supporting details.';
$string['elc_en_wr_b2_5'] = 'I can write about events and real or fictional experiences in a detailed and easily readable way.';
$string['elc_en_wr_b2_6'] = 'I can write a short review of a film or a book.';
$string['elc_en_wr_b2_7'] = 'I can express, in a personal letter or e-mail, different feelings and attitudes and can report the news of the day making clear what – in my opinion – are the important aspects of an event.';
$string['elc_en_wr_b2_8'] = 'I can write summaries of scientific texts in my field for use at a later date.';
$string['elc_en_wr_b2_9'] = 'I can write seminar papers on my own, although I must have them checked for linguistic accuracy and appropriateness.';

$string['elc_en_wr_c1_1'] = 'I can express myself in writing on a wide range of general or professional topics in a clear and user-friendly manner.';
$string['elc_en_wr_c1_2'] = 'I can present a complex topic in a clear and well-structured way, highlighting the most important points, for example in a composition or a report.';
$string['elc_en_wr_c1_3'] = 'I can present points of view in a comment on a topic or an event, underlining the main ideas and supporting my reasoning with detailed examples.';
$string['elc_en_wr_c1_4'] = 'I can put together information from different sources and present it in a coherent summary.';
$string['elc_en_wr_c1_5'] = 'I can give a detailed description of experiences, feelings and events in a personal letter.';
$string['elc_en_wr_c1_6'] = 'I can write formally correct letters, for example to complain or to take a stand in favour of or against something.';
$string['elc_en_wr_c1_7'] = 'I can write texts which show a high degree of grammatical correctness, and vary my vocabulary and style according to the target reader, the kind of text and the topic.';
$string['elc_en_wr_c1_8'] = 'I can select a style appropriate to the target reader.';
$string['elc_en_wr_c1_9'] = 'I can use the specialised terms and idiomatic expressions in my field without major difficulty.';

$string['elc_en_wr_c2_1'] = 'I can write well-structured and easily readable reports and articles on complex topics.';
$string['elc_en_wr_c2_2'] = 'In a report or an essay I can give a complete account of a topic based on research I have carried out, make a summary of the opinions of others, and give and evaluate detailed information and facts.';
$string['elc_en_wr_c2_3'] = 'I can write a well-structured review of a paper or a project giving reasons for my opinion.';
$string['elc_en_wr_c2_4'] = 'I can write a critical review of cultural events (film, music, theatre, literature, radio, TV).';
$string['elc_en_wr_c2_5'] = 'I can write summaries of factual texts and literary works.';
$string['elc_en_wr_c2_6'] = 'I can write narratives about experiences in a clear, fluent style appropriate to the genre.';
$string['elc_en_wr_c2_7'] = 'I can write clear, well-structured, complex letters in an appropriate style, for example an application or request, an offer to authorities, superiors or commercial clients.';
$string['elc_en_wr_c2_8'] = 'In a letter or an e-mail I can express myself in a consciously ironical, ambiguous and humorous way.';
$string['elc_en_wr_c2_9'] = 'I can write scientific texts in my field, with a view to being published, that are generally correct and stylistically appropriate.';
$string['elc_en_wr_c2_10'] = 'I can write a critical essay (e.g., a review) of scientific literature for publication in my field.';
$string['elc_en_wr_c2_11'] = 'I can take accurate and complete notes during a lecture, seminar, or tutorial.';
$string['elc_en_wr_c2_12'] = 'I can summarise information from different sources, reconstructing arguments in such a way that the overall result is a coherent presentation.';
$string['elc_en_wr_c2_13'] = 'I can edit colleagues\' texts, improving them grammatically and stylistically, with little hesitation.';

/*
 * descriptors ELC French
 */
 
//Listening A1
$string['elc_fr_li_a1_1'] = 'Je peux comprendre si on parle très lentement et distinctement avec moi et s’il y a de longues pauses qui me laissent le temps de saisir le sens.';
$string['elc_fr_li_a1_2'] = 'Je peux comprendre des indications simples : comment aller de A à B, à pied ou par les transports publics.';
$string['elc_fr_li_a1_3'] = 'Je peux comprendre une question ou une invitation à faire quelque chose lorsqu’elles me sont adressées distinctement et lentement, et je peux suivre des instructions brèves et simples.';
$string['elc_fr_li_a1_4'] = 'Je peux comprendre les nombres, les prix et l’heure.';

//Listening A2
$string['elc_fr_li_a2_1'] = 'Je peux comprendre ce qu’on me dit, dans une conversation simple et quotidienne, si le débit est clair et lent ; il est possible, lorsqu’on s’en donne la peine, de se faire comprendre par moi.';
$string['elc_fr_li_a2_2'] = 'Je peux comprendre, en règle générale, le sujet de la conversation qui se déroule en ma présence si le débit est clair et lent.';
$string['elc_fr_li_a2_3'] = 'Je peux comprendre des phrases, expressions et mots relatifs à ce qui me concerne de très près (par ex. des informations très élémentaires sur moi-même, ma famille, les achats, l’environnement proche, le travail).';
$string['elc_fr_li_a2_4'] = 'Je peux saisir l’essentiel d’annonces et de messages brefs, simples et clairs.';
$string['elc_fr_li_a2_5'] = 'Je peux capter les informations essentielles de courts passages enregistrés ayant trait à un sujet courant et prévisible, si l’on parle d’une façon lente et distincte.';
$string['elc_fr_li_a2_6'] = 'Je peux saisir l’information essentielle de nouvelles télévisées sur un événement, un accident, etc., si le commentaire est accompagné d’images éclairantes.';

//Listening B1
$string['elc_fr_li_b1_1'] = 'Je peux suivre une conversation quotidienne si le / la partenaire s’exprime clairement, mais je dois parfois lui demander de répéter certains mots ou expressions.';
$string['elc_fr_li_b1_2'] = 'Je peux généralement suivre les points principaux d’une discussion d’une certaine longueur se déroulant en ma présence, à condition que l’on parle distinctement et dans un langage standard.';
$string['elc_fr_li_b1_3'] = 'Je peux écouter une brève narration et formuler des hypothèses sur ce qui va se passer.';
$string['elc_fr_li_b1_4'] = 'Je peux comprendre les points principaux d’un journal radio ou d’un enregistrement audio simple sur des sujets familiers si le débit est relativement lent et clair.';
$string['elc_fr_li_b1_5'] = 'Je peux saisir les points principaux d’une émission de télévision sur des sujets familiers si le débit est relativement lent et clair.';
$string['elc_fr_li_b1_6'] = 'Je peux comprendre de simples directives techniques, par ex. des indications sur l’utilisation d’un appareil d’usage quotidien.';
//$string['elc_fr_li_b1_7'] = 'Ich kann in Diskussionen (z.B. in einem Seminar, bei einer Podiums - oder Fernsehdiskussion) die Hauptpunkte erfassen, wenn es um ein vertrautes Thema aus meinem Fachgebiet geht, vorausgesetzt es wird deutlich gesprochen und Standardsprache verwendet.';
//$string['elc_fr_li_b1_8'] = 'Ich kann in einer Vorlesung Notizen zu den Hauptaussagen machen, die für den eigenen Gebrauch genügen, sofern das Thema zu meinem Fachgebiet gehört und der Vortrag klar und gut strukturiert ist.';

//Listening B2
$string['elc_fr_li_b2_1'] = 'Je peux comprendre en détails ce qu’on me dit dans un langage standard, même dans un environnement bruyant.';
$string['elc_fr_li_b2_2'] = 'Je peux suivre une présentation ou un cours dans mes domaines de spécialisation et d’intérêt, si le sujet m’en est familier et si la structure en est claire et simple.';
$string['elc_fr_li_b2_3'] = 'Je peux comprendre la plupart des documentaires radiophoniques si la langue utilisée est standard et saisir l’humeur, le ton, etc. des gens qui s’expriment.';
$string['elc_fr_li_b2_4'] = 'Je peux comprendre un reportage, une interview, un talk-show, un téléfilm et la plupart des films à la télévision, à condition que ce soit en langue standard et non pas en dialecte.';
$string['elc_fr_li_b2_5'] = 'Je peux comprendre les points principaux d’interventions complexes sur un sujet concret ou abstrait à condition que ce soit en langue standard ; je peux aussi comprendre des discussions relatives à mon domaine de spécialisation.';
$string['elc_fr_li_b2_6'] = 'Je peux, pour comprendre, utiliser des stratégies variées – par exemple repérer les points principaux et vérifier ma compréhension en utilisant des indices contextuels.';
//$string['elc_fr_li_b2_7'] = 'Ich kann eine strukturierte Vorlesung über ein vertrautes Thema verstehen und mir die Punkte notieren, die mir wichtig erscheinen, auch wenn ich manchmal an Wörtern hängen bleibe und deshalb einen Teil der Informationen verpasse.';

//Listening C1
$string['elc_fr_li_c1_1'] = 'Je peux suivre une intervention ou une conversation d’une certaine longueur, même si elle n’est pas clairement structurée et les relations entre les idées ne sont pas explicitement exposées.';
$string['elc_fr_li_c1_2'] = 'Je peux comprendre une grande gamme d’expressions idiomatiques et de tournures courantes et reconnaître les changements de style et de ton.';
$string['elc_fr_li_c1_3'] = 'Je peux saisir des informations spécifiques dans des annonces publiques, même si la qualité de transmission est mauvaise – par exemple dans une gare ou lors d’une manifestation sportive.';
$string['elc_fr_li_c1_4'] = 'Je peux comprendre une information technique complexe, par exemple des modes d’emploi ou des précisions sur un produit ou un service qui me sont familiers.';
$string['elc_fr_li_c1_5'] = 'Je peux comprendre une conférence, un exposé ou un rapport dans le cadre de mon travail, de ma formation ou de mes études, même s’ils sont complexes quant au fond et à la forme.';
$string['elc_fr_li_c1_6'] = 'Je peux comprendre un film sans trop de difficulté, même s’il comporte beaucoup d’argot et d’expressions idiomatiques.';
//$string['elc_fr_li_c1_7'] = 'Ich kann den Inhalt von Radio- und Fernsehsendungen verstehen, die meinen Fachbereich betreffen, auch wenn sie anspruchsvoll und sprachlich komplex sind.';
//$string['elc_fr_li_c1_8'] = 'Ich kann im Detail verstehen, wenn über abstrakte, komplexe Themen auf fremden Fachgebieten gesprochen wird, muss jedoch manchmal Einzelheiten bestätigen lassen, besonders wenn mit wenig vertrautem Akzent gesprochen wird.';
//$string['elc_fr_li_c1_9'] = 'Ich kann einer Vorlesung zu Themen meines Fachgebietes detaillierte Notizen machen, und zwar so exakt und nahe am Original, dass diese Notizen auch für andere nützlich sind.';

//Listening C2
$string['elc_fr_li_c2_1'] = 'Je n’ai aucune difficulté à comprendre le langage oral, qu’il soit «live» ou dans les médias, même quand on parle vite. J’ai juste besoin d’un peu de temps pour m’habituer à un accent particulier.';
//$string['elc_fr_li_c2_2'] = 'Ich kann Fachvorträge oder Präsentationen verstehen, die viele umgangssprachliche oder regional gefärbte Ausdrücke oder auch fremde Terminologie enthalten.';
//$string['elc_fr_li_c2_3'] = 'Ich bemerke in Vorlesungen und Seminaren, was nur implizit gesagt wird und worauf nur angespielt wird und kann mir dazu ebenso Notizen machen wie zu dem, was ein Sprecher direkt ausdrückt.';

//-----------------------------------------

//Reading A1
$string['elc_fr_re_a1_1'] = 'Je peux comprendre les informations concernant des personnes (domicile, âge etc.) en lisant le journal.';
$string['elc_fr_re_a1_2'] = 'Je peux choisir un concert ou un film en lisant des affiches ou des programmes de manifestations et je peux comprendre où et quand il a lieu.';
$string['elc_fr_re_a1_3'] = 'Je peux comprendre suffisamment un questionnaire (à la frontière, à l’arrivée à l’hôtel) pour y indiquer par ex. mes noms, prénoms, date de naissance, nationalité.';
$string['elc_fr_re_a1_4'] = 'Je peux comprendre les mots et expressions sur les panneaux indicateurs que l’on rencontre dans la vie quotidienne (par ex. «gare», «centre», «parking», «défense de fumer», «serrer à droite»).';
$string['elc_fr_re_a1_5'] = 'Je peux comprendre les principales consignes d’un programme informatique, par ex. «sauvegarder», «ouvrir», «fermer», «effacer».';
$string['elc_fr_re_a1_6'] = 'Je peux comprendre de brèves et simples indications écrites (par ex. de parcours).';
$string['elc_fr_re_a1_7'] = 'Je peux comprendre des messages brefs et simples sur une carte postale, par ex. une carte de vacances.';
$string['elc_fr_re_a1_8'] = 'Je peux comprendre dans la vie quotidienne les messages simples, laissés par mes connaissances et collaborateurs, par ex. «Je reviens à 16 heures».';

//Reading A2
$string['elc_fr_re_a2_1'] = 'Je peux saisir les informations importantes de nouvelles ou d’articles de journaux simples qui sont bien structurés et illustrés et dans lesquelles les noms et les chiffres jouent un grand rôle.';
$string['elc_fr_re_a2_2'] = 'Je peux comprendre une lettre personnelle simple dans laquelle on me raconte des faits de la vie quotidienne ou me pose des questions à ce sujet.';
$string['elc_fr_re_a2_3'] = 'Je peux comprendre les communications écrites simples, laissées par mes connaissances ou collaborateurs (par ex. m’indiquant à quelle heure se retrouver pour aller au match ou me demandant d’aller au travail plus tôt).';
$string['elc_fr_re_a2_4'] = 'Je peux trouver les informations les plus importantes de dépliants sur des activités de loisirs, des expositions, etc.';
$string['elc_fr_re_a2_5'] = 'Je peux parcourir les petites annonces dans les journaux, trouver la rubrique qui m’intéresse et identifier les informations les plus importantes, par ex. dimensions et prix d’un appartement, d’une voiture, d’un ordinateur etc.';
$string['elc_fr_re_a2_6'] = 'Je peux comprendre les modes d’emploi simples pour un équipement (par ex. pour le téléphone public).';
$string['elc_fr_re_a2_7'] = 'Je peux comprendre les messages et les aides simples de programmes informatiques.';
$string['elc_fr_re_a2_8'] = 'Je peux comprendre de brefs récits qui parlent de choses quotidiennes et de thèmes familiers, s’ils sont écrits de manière simple.';

//Reading B1
$string['elc_fr_re_b1_1'] = 'Je comprends les points essentiels d’articles courts sur des sujets d’actualité ou familiers.';
$string['elc_fr_re_b1_2'] = 'Je peux deviner le sens de certains mots inconnus grâce au contexte, ce qui me permet de déduire le sens des énoncés à condition que le sujet me soit familier.';
$string['elc_fr_re_b1_3'] = 'Je peux parcourir rapidement des textes brefs (par ex. des nouvelles en bref) et trouver des faits ou des informations importantes (par ex. qui a fait quoi et où).';
$string['elc_fr_re_b1_4'] = 'Je peux comprendre les communications simples et les lettres standard, provenant par ex. du commerce, d’associations et de services publics.';
$string['elc_fr_re_b1_5'] = 'Je peux comprendre suffisamment, dans la correspondance privée, ce qui est écrit sur les événements, les sentiments ou les désirs pour pouvoir entretenir une correspondance régulière avec un/e correspondant/e.';
$string['elc_fr_re_b1_6'] = 'Je peux suivre l’intrigue d’une histoire si elle est bien structurée, reconnaître les épisodes et les événements les plus importants et comprendre pourquoi ils sont significatifs.';
//$string['elc_fr_re_b1_7'] = 'Ich kann in klar geschriebenen argumentativen Texten die wesentlichen Schlussfolgerungen erkennen. ';
//$string['elc_fr_re_b1_8'] = 'Ich kann unkomplizierte Sachtexte über Themen, die mit den eigenen Interessen und Fachgebieten in Zusammenhang stehen, mit befriedigendem Verständnis lesen. ';
//$string['elc_fr_re_b1_9'] = 'Ich kann längere Texte aus meinem Fachgebiet nach gewünschten Informationen durchsuchen und Informationen aus verschiedenen Texten oder Textteilen zusammentragen, um eine bestimmte Aufgabe zu lösen.';
$string['elc_fr_re_b1_7'] = 'Je peux comprendre les prises de position et les interviews d’un journal ou d’un magazine sur des thèmes ou des événements d’actualité et j’en saisis les arguments essentiels.';
$string['elc_fr_re_b1_8'] = 'Je peux comprendre les informations les plus importantes dans des brochures d’information brèves et simples de la vie quotidienne.';

//Reading B2
$string['elc_fr_re_b2_1'] = 'Je peux saisir rapidement le contenu et l’importance d’articles et de comptes-rendus relatifs aux domaines qui m’intéressent ou à ma profession et décider s’il vaut la peine de les lire attentivement.';
$string['elc_fr_re_b2_2'] = 'Je peux lire et comprendre des articles et des comptes-rendus sur des thèmes d’actualité dans lesquels les auteurs prennent des positions particulières et défendent des attitudes particulières.';
$string['elc_fr_re_b2_3'] = 'Je peux comprendre en détails des textes sur des thèmes qui touchent à mes domaines de spécialisation et d’intérêt.';
$string['elc_fr_re_b2_4'] = 'Je peux comprendre des articles spécialisés qui sortent de mon domaine à condition de recourir, de temps en temps, au dictionnaire.';
$string['elc_fr_re_b2_5'] = 'Je peux lire des critiques se rapportant au contenu et à l’appréciation de thèmes culturels (film, théâtre, livre, concert) et en résumer les affirmations les plus importantes.';
$string['elc_fr_re_b2_6'] = 'Je peux saisir les points essentiels d’une correspondance en relation avec mon domaine de spécialisation, mes études ou mes intérêts personnels.';
$string['elc_fr_re_b2_7'] = 'Je peux parcourir rapidement un manuel (par ex. sur un programme informatique), et je peux y trouver et comprendre les explications nécessaires pour résoudre un problème particulier.';
$string['elc_fr_re_b2_8'] = 'Je peux reconnaître, en lisant un texte narratif ou dramatique, les raisons qui poussent les personnages à agir et les conséquences de leurs décisions sur le déroulement de l’action.';

//Reading C1
$string['elc_fr_re_c1_1'] = 'Je peux comprendre et résumer oralement des textes exigeants et d’une certaine longueur';
$string['elc_fr_re_c1_2'] = 'Je peux lire des rapports détaillés, des analyses et des commentaires dans lesquels sont exposés des opinions, des points de vue et des relations d’idées.';
$string['elc_fr_re_c1_3'] = 'Je peux extraire des informations, des idées et des opinions de textes hautement spécialisés dans mon domaine de compétence (par ex. des rapports de recherche).';
$string['elc_fr_re_c1_4'] = 'Je peux comprendre des instructions et des indications complexes et d’une certaine longueur, par ex. sur l’utilisation d’un nouvel appareil, même si elles ne sont pas en relation avec mon domaine de spécialisation ou d’intérêt, à condition d’avoir suffisamment de temps pour les lire.';
$string['elc_fr_re_c1_5'] = 'Je peux comprendre tous types de correspondance en recourant de temps en temps au dictionnaire.';
$string['elc_fr_re_c1_6'] = 'Je peux lire couramment des textes littéraires contemporains.';
$string['elc_fr_re_c1_7'] = 'Dans un texte littéraire, je peux faire abstraction de l’histoire racontée et saisir les messages, idées et rapports implicites.';
$string['elc_fr_re_c1_8'] = 'Je peux reconnaître le contexte social, politique ou historique d’une oeuvre littéraire.';

//Reading C2
$string['elc_fr_re_c2_1'] = 'Je peux saisir les jeux de mots et comprendre correctement un texte dont le message est implicite, en reconnaissant, par ex., l’ironie, la satire.';
$string['elc_fr_re_c2_2'] = 'Je peux comprendre des textes écrits dans un style très familier avec beaucoup d’expressions idiomatiques ou argotiques.';
$string['elc_fr_re_c2_3'] = 'Je peux comprendre des manuels, règlements et des contrats même dans des domaines non-familiers.';
$string['elc_fr_re_c2_4'] = 'Je peux lire des textes appartenant aux différents genres de la littérature classique et contemporaine (poésie, prose, théâtre).';
$string['elc_fr_re_c2_5'] = 'Je peux lire des textes tels que chroniques littéraires ou commentaires satiriques, qui contiennent beaucoup d’informations indirectes et ambiguës et de jugements de valeur implicites.';
$string['elc_fr_re_c2_6'] = 'Je peux distinguer les effets de style les plus variés (jeux de mots, métaphores, thèmes littéraires, connotations, symboles, ambiguïté) et apprécier leur fonction dans le texte.';
//$string['elc_fr_re_c2_7'] = 'Ich kann lange, komplexe, wissenschaftliche Texte im Detail verstehen, auch wenn diese nicht meinem eigenen Spezialgebiet angehören.';

//-----------------------------------------

//Spoken Interaction A1
$string['elc_fr_si_a1_1'] = 'Je peux présenter quelqu’un et utiliser des expressions de salutations et de prises de congé simples.';
$string['elc_fr_si_a1_2'] = 'Je peux répondre à des questions simples et en poser, je peux réagir à des déclarations simples et en faire, pour autant qu’il s’agisse de quelque chose de tout à fait familier ou dont j’ai immédiatement besoin.';
$string['elc_fr_si_a1_3'] = 'Je peux communiquer de façon simple, mais j’ai besoin que la personne qui parle avec moi soit prête à répéter plus lentement ou à reformuler et qu’elle m’aide à formuler ce que j’aimerais dire.';
$string['elc_fr_si_a1_4'] = 'Je peux faire des achats simples lorsque je peux m’aider en faisant des mimiques ou en pointant du doigt les objets concernés.';
$string['elc_fr_si_a1_5'] = 'Je peux me débrouiller avec les notions de nombre, de quantité, d’heure et de prix.';
$string['elc_fr_si_a1_6'] = 'Je peux demander ou donner quelque chose à quelqu’un.';
$string['elc_fr_si_a1_7'] = 'Je peux poser des questions personnelles à quelqu’un, par exemple sur son lieu d’habitation, ses relations, les choses qui lui appartiennent, etc., et je peux répondre au même type de questions si elles sont formulées lentement et distinctement.';
$string['elc_fr_si_a1_8'] = 'Je peux donner des indications temporelles en utilisant des expressions telles que «la semaine prochaine», «vendredi dernier», «en novembre», «à trois heures».';

//Spoken Interaction A2
$string['elc_fr_si_a2_1'] = 'Je peux effectuer des opérations simples dans un magasin, un bureau de poste ou une banque.';
$string['elc_fr_si_a2_2'] = 'Je peux utiliser les transports publics (bus, train, taxi), demander un renseignement sommaire ou acheter un billet.';
$string['elc_fr_si_a2_3'] = 'Je peux obtenir des renseignements simples pour un voyage.';
$string['elc_fr_si_a2_4'] = 'Je peux commander quelque chose à boire ou à manger.';
$string['elc_fr_si_a2_5'] = 'Je peux faire des achats simples, dire ce que je cherche et en demander le prix.';
$string['elc_fr_si_a2_6'] = 'Je peux demander le chemin ou l’indiquer avec une carte ou un plan.';
$string['elc_fr_si_a2_7'] = 'Je peux saluer quelqu’un, lui demander de ses nouvelles et réagir si j’apprends quelque chose de nouveau.';
$string['elc_fr_si_a2_8'] = 'Je peux inviter quelqu’un et réagir si on m’invite.';
$string['elc_fr_si_a2_9'] = 'Je peux m’excuser ou accepter des excuses.';
$string['elc_fr_si_a2_10'] = 'Je peux dire ce que j’aime ou non.';
$string['elc_fr_si_a2_11'] = 'Je peux discuter avec quelqu’un de ce qu’on va faire et où on va aller et je peux convenir de l’heure et du lieu de rendez-vous.';
$string['elc_fr_si_a2_12'] = 'Je peux poser des questions à quelqu’un sur son travail et son temps libre ; je peux répondre au même type de questions.';

//Spoken Interaction B1
$string['elc_fr_si_b1_1'] = 'Je peux commencer, soutenir et terminer une simple conversation en tête-à-tête sur un sujet familier ou d’intérêt personnel.';
$string['elc_fr_si_b1_2'] = 'Je peux prendre part à une conversation ou une discussion, mais il est possible qu’on ne me comprenne pas toujours quand j’essaie de dire ce que j’aimerais dire.';
$string['elc_fr_si_b1_3'] = 'Je peux me débrouiller dans la plupart des situations pouvant se produire en réservant un voyage auprès d’une agence ou lors d’un voyage.';
$string['elc_fr_si_b1_4'] = 'Je peux exprimer des sentiments tels que la surprise, la joie, la tristesse, la curiosité et l’indifférence et réagir aux mêmes types de sentiments exprimés par d’autres.';
$string['elc_fr_si_b1_5'] = 'Je peux échanger un point de vue ou une opinion personnels dans une discussion avec des connaissances ou des amis.';
$string['elc_fr_si_b1_6'] = 'Je peux exprimer poliment mon accord ou mon désaccord.';
//$string['elc_fr_si_b1_7'] = 'Ich kann in informellen Situationen mit Kollegen/Mitstudierenden über Fachinhalte sprechen. ';
//$string['elc_fr_si_b1_8'] = 'Ich kann die meisten Gesprächssituationen bewältigen, die mit der Organisation des Studiums zusammenhängen, normalerweise auch am Telefon.';
$string['elc_fr_si_b1_7'] = 'Je peux demander mon chemin et suivre les indications détaillées que l’on me donne.';

//Spoken Interaction B2
$string['elc_fr_si_b2_1'] = 'Je peux commencer, soutenir et terminer une conversation avec naturel en sachant prendre et céder la parole.';
$string['elc_fr_si_b2_2'] = 'Je peux échanger un grand nombre d’informations détaillées sur des sujets dans mes domaines de spécialisation et d’intérêt.';
$string['elc_fr_si_b2_3'] = 'Je peux exprimer des émotions d’intensité variée et souligner ce qui est important pour moi dans un événement ou une expérience.';
$string['elc_fr_si_b2_4'] = 'Je peux participer activement à une conversation d’une certaine longueur sur la plupart des thèmes d’intérêt général.';
$string['elc_fr_si_b2_5'] = 'Je peux motiver et défendre mes opinions dans une discussion avec des explications, des arguments et des commentaires.';
$string['elc_fr_si_b2_6'] = 'Je peux contribuer au déroulement d’une conversation dans un domaine qui m’est familier en confirmant que je comprends ou en invitant les autres à dire quelque chose.';
$string['elc_fr_si_b2_7'] = 'Je peux mener une interview préparée au préalable, demander si ce que j’ai compris est correct et approfondir les réponses intéressantes.';
//$string['elc_fr_si_b2_8'] = 'Ich kann mich innerhalb und außerhalb von Lehrveranstaltungen aktiv an Gesprächen über fachliche oder kulturelle Themen beteiligen. ';
//$string['elc_fr_si_b2_9'] = 'Ich kann effizient Probleme lösen, die mit der Organisation des Studiums zusammenhängen, z.B. in Kontakten mit Dozierenden und der Verwaltung.';

//Spoken Interaction C1
$string['elc_fr_si_c1_1'] = 'Je peux participer activement à des discussions, même très animées, entre locuteurs natifs.';
$string['elc_fr_si_c1_2'] = 'Je peux parler couramment, correctement et efficacement sur une grande gamme de thèmes généraux, professionnels ou scientifiques.';
$string['elc_fr_si_c1_3'] = 'Je peux manier la langue, en société, avec souplesse et efficacité, y compris pour exprimer un sentiment, ou pour faire une allusion ou de l’humour.';
$string['elc_fr_si_c1_4'] = 'Je peux exprimer mes idées et opinions dans une discussion avec précision et clarté, je peux argumenter de manière persuasive et réagir efficacement à un raisonnement complexe.';

//Spoken Interaction C2
$string['elc_fr_si_c2_1'] = 'Je peux participer sans effort à n’importe quelle conversation ou discussion avec des locuteurs natifs.';
//$string['elc_fr_si_c2_2'] = 'Ich beherrsche idiomatische und umgangssprachliche Wendungen sowie Fachjargon in meinem Spezialgebiet gut und bin mir der jeweiligen Konnotationen bewusst. Ich kann auch feinere Bedeutungsnuancen deutlich machen. ';
//$string['elc_fr_si_c2_3'] = 'Ich kann mich in formellen Diskussionen über komplexe Themen behaupten, indem ich klar und überzeugend argumentiere; dabei bin ich gegenüber Muttersprachlern nicht im Nachteil. ';
//$string['elc_fr_si_c2_4'] = 'Ich kann mit schwierigen und auch unfreundlichen Fragen umgehen, die mir im Anschluss an ein Referat oder eine Präsentation gestellt werden. ';

//$string['elc_fr_si_c2_5'] = 'Ich kann Informationen aus verschiedenen Quellen mündlich zusammenfassen und dabei die enthaltenen Argumente und Sachverhalte in einer klaren zusammenhängenden Darstellung wiedergeben. ';
//$string['elc_fr_si_c2_6'] = 'Ich kann Gedanken und Standpunkte sehr flexibel vortragen und dabei etwas hervorheben, differenzieren und Mehrdeutigkeit beseitigen. ';
//$string['elc_fr_si_c2_7'] = 'Ich kann sicher und gut verständlich einem Publikum ein komplexes Thema vortragen, mit dem es nicht vertraut ist, und dabei die Rede flexibel den Bedürfnissen des Publikums anpassen und entsprechend strukturieren.';

//-----------------------------------------

//Spoken Production A1
$string['elc_fr_sp_a1_1'] = 'Je peux donner des renseignements sur moi-même (par ex. adresse, numéro de téléphone, nationalité, âge, famille, hobbys).';
$string['elc_fr_sp_a1_2'] = 'Je peux décrire où j’habite.';

//Spoken Production A2
$string['elc_fr_sp_a2_1'] = 'Je peux me décrire ainsi que ma famille ou d’autres personnes.';
$string['elc_fr_sp_a2_2'] = 'Je peux décrire où j’habite.';
$string['elc_fr_sp_a2_3'] = 'Je peux rapporter brièvement et simplement un événement.';
$string['elc_fr_sp_a2_4'] = 'Je peux décrire ma formation et mon activité professionnelle actuelle ou récente.';
$string['elc_fr_sp_a2_5'] = 'Je peux parler de manière simple de mes loisirs et de mes intérêts.';
$string['elc_fr_sp_a2_6'] = 'Je peux parler d’activités et d’expériences personnelles, par ex. mon dernier week-end, mes vacances.';

//Spoken Production B1
$string['elc_fr_sp_b1_1'] = 'Je peux raconter une histoire.';
$string['elc_fr_sp_b1_2'] = 'Je peux relater en détails une expérience et décrire mes sentiments et réactions.';
$string['elc_fr_sp_b1_3'] = 'Je peux décrire un rêve, un espoir ou un but.';
$string['elc_fr_sp_b1_4'] = 'Je peux justifier ou expliquer brièvement mes intentions, plans ou actes.';
$string['elc_fr_sp_b1_5'] = 'Je peux raconter l’intrigue d’un livre ou d’un film et décrire mes réactions.';
$string['elc_fr_sp_b1_6'] = 'Je peux rapporter oralement et de façon simple de courts passages d’un texte écrit en utilisant les mots et l’ordre du texte original.';
//$string['elc_fr_sp_b1_7'] = 'Ich kann zu verschiedenen vertrauten Themen meines Interessen- oder Fachbereichs unkomplizierte Beschreibungen oder Berichte geben. ';
//$string['elc_fr_sp_b1_8'] = 'Ich kann eine vorbereitete, unkomplizierte Präsentation zu einem vertrauten Thema aus meinem Fachgebiet klar und präzise genug vortragen, dass man ihr meist mühelos folgen kann und die Hauptpunkte verstanden werden.';

//Spoken Production B2
$string['elc_fr_sp_b2_1'] = 'Je peux faire une description ou un rapport clairs et détaillés sur beaucoup de thèmes dans mes domaines d’intérêt.';
$string['elc_fr_sp_b2_2'] = 'Je peux comprendre et résumer oralement de courts extraits d’un bulletin d’informations, d’une interview ou d’un reportage contenant prises de positions, arguments et discussion.';
$string['elc_fr_sp_b2_3'] = 'Je peux comprendre et résumer oralement l’intrigue et la suite d’événements d’un extrait de film ou d’une pièce de théâtre.';
$string['elc_fr_sp_b2_4'] = 'Je peux construire un raisonnement logique et enchaîner mes idées.';
$string['elc_fr_sp_b2_5'] = 'Je peux expliquer mon point de vue sur un problème en exposant les avantages et les inconvénients de diverses options.';
$string['elc_fr_sp_b2_6'] = 'Je peux faire des suppositions sur des causes, des conséquences et parler de situations hypothétiques.';
//$string['elc_fr_sp_b2_7'] = 'Ich kann im eigenen Fach frei oder nach Stichworten einen Kurzvortrag halten.';
//$string['elc_fr_sp_b2_8'] = 'Ich kann aus verschiedenen schriftlichen Quellen stammende Informationen und Argumente zusammenfassen und mündlich wiedergeben.';

//Spoken Production C1
$string['elc_fr_sp_c1_1'] = 'Je peux exposer clairement et de façon détaillée des sujets complexes.';
$string['elc_fr_sp_c1_2'] = 'Je peux résumer oralement un texte long et exigeant.';
$string['elc_fr_sp_c1_3'] = 'Je peux exposer ou rapporter oralement quelque chose de façon détaillée, en reliant les points thématiques les uns aux autres, en développant particulièrement certains aspects et en terminant mon intervention de façon appropriée.';
$string['elc_fr_sp_c1_4'] = 'Je peux faire un exposé clair et structuré dans mes domaines de spécialisation et d’intérêt, en m’écartant, si nécessaire, du texte préparé et en répondant spontanément aux questions des auditeurs.';

//Spoken Production C2
$string['elc_fr_sp_c2_1'] = 'Je peux comprendre et résumer oralement des informations de diverses sources, en reproduisant arguments et contenus factuels dans une présentation claire et cohérente.';
$string['elc_fr_sp_c2_2'] = 'Je peux exposer avec une grande souplesse des concepts et des points de vue ce qui me permet de souligner ou différencier les informations et de lever les ambiguïtés.';
//$string['elc_fr_sp_c2_3'] = 'Ich kann sicher und gut verständlich einem Publikum ein komplexes Thema vortragen, mit dem es nicht vertraut ist, und dabei die Rede flexibel den Bedürfnissen des Publikums anpassen und entsprechend strukturieren.';

//-----------------------------------------

//Kompetenz "Strategies" bzw. "Strategien" ergänzen.


//-----------------------------------------

//Kompetenz "Language Quality" bzw. "Qualität/Sprachliche Mittel" ergänzen


//-----------------------------------------

//Writing A1
$string['elc_fr_wr_a1_1'] = 'Je peux inscrire des détails personnels dans un questionnaire (profession, âge, domicile, hobbys).';
$string['elc_fr_wr_a1_2'] = 'Je peux écrire une carte de voeux, par ex. pour un anniversaire.';
$string['elc_fr_wr_a1_3'] = 'Je peux écrire une carte postale simple, par exemple de vacances.';
$string['elc_fr_wr_a1_4'] = 'Je peux écrire une note pour indiquer brièvement à quelqu’un l’endroit où je me trouve ou le lieu où nous allons nous rencontrer.';
$string['elc_fr_wr_a1_5'] = 'Je peux écrire de simples phrases sur moi-même, par ex. où j’habite et ce que je fais.';

//Writing A2
$string['elc_fr_wr_a2_1'] = 'Je peux écrire une note brève ou un message simple.';
$string['elc_fr_wr_a2_2'] = 'Je peux décrire avec des phrases simples un événement et dire ce qui s’est passé (où, quand, quoi), par ex. une fête ou un accident.';
$string['elc_fr_wr_a2_3'] = 'Je peux écrire avec des phrases et des expressions simples sur des aspects de la vie quotidienne (les gens, les lieux, le travail, l’école, la famille, les hobbys).';
$string['elc_fr_wr_a2_4'] = 'Je peux donner, dans un questionnaire, des informations sur ma formation, mon travail, mes intérêts et mes domaines de spécialité.';
$string['elc_fr_wr_a2_5'] = 'Je peux me présenter dans une lettre avec des phrases et des expressions simples (famille, école, travail, hobbys).';
$string['elc_fr_wr_a2_6'] = 'Je peux écrire une brève lettre en utilisant des formules d’adresse, de salutations, de remerciements et pour demander quelque chose.';
$string['elc_fr_wr_a2_7'] = 'Je peux écrire des phrases simples et les relier par des mots tels que «et», «mais», «parce que».';
$string['elc_fr_wr_a2_8'] = 'Je peux utiliser les mots nécessaires pour exprimer la chronologie des événements («d’abord», «ensuite», «plus tard», «après»).';

//Writing B1
$string['elc_fr_wr_b1_1'] = 'Je peux écrire un texte simple et cohérent sur des thèmes différents dans mon domaine d’intérêt et exprimer des opinions et des idées personnelles.';
$string['elc_fr_wr_b1_2'] = 'Je peux rédiger des textes simples sur des expériences ou des événements (par ex. sur un voyage) pour le journal de l’école ou d’une société.';
$string['elc_fr_wr_b1_3'] = 'Je peux rédiger des lettres personnelles à des connaissances ou à des amis et demander ou donner des nouvelles ou raconter des événements.';
$string['elc_fr_wr_b1_4'] = 'Je peux raconter, dans une lettre personnelle, l’intrigue d’un livre ou d’un film ou parler d’un concert.';
$string['elc_fr_wr_b1_5'] = 'Je peux exprimer dans une lettre des sentiments comme la tristesse, la joie, l’intérêt, la sympathie ou le regret.';
$string['elc_fr_wr_b1_6'] = 'Je peux réagir par écrit à une annonce et demander des renseignements complémentaires ou plus précis sur un produit (par ex. sur une voiture ou sur un cours).';
$string['elc_fr_wr_b1_7'] = 'Je peux rédiger un fax, un e-mail ou un message pour transmettre des informations spécifiques, simples et brèves à des amis ou à des collaborateurs.';
$string['elc_fr_wr_b1_8'] = 'Je peux rédiger un curriculum vitae simple (sous forme de tableau).';
//$string['elc_fr_wr_b1_9'] = 'Ich kann in meinem Fachgebiet den Verlauf eines wissenschaftlichen Experiments in Stichworten festhalten. ';
//$string['elc_fr_wr_b1_10'] = 'Ich kann in meinem Fachgebiet einfache Texte verfassen und dabei wichtige Fachbegriffe richtig gebrauchen.';

//Writing B2
$string['elc_fr_wr_b2_1'] = 'Je peux écrire des textes clairs et détaillés sur différents sujets, dans mes domaines d’intérêt, sous forme de rédaction, de rapport ou d’exposé.';
$string['elc_fr_wr_b2_2'] = 'Je peux résumer des articles sur des sujets d’intérêt général.';
$string['elc_fr_wr_b2_3'] = 'Je peux résumer des informations provenant de différentes sources et médias.';
$string['elc_fr_wr_b2_4'] = 'Je peux développer systématiquement un sujet sous forme de rédaction ou de rapport en soulignant les points essentiels et en donnant des informations qui soutiennent mon argumentation.';
$string['elc_fr_wr_b2_5'] = 'Je peux écrire avec fluidité sur des faits ou des expériences réelles ou fictives en donnant suffisamment de détails.';
$string['elc_fr_wr_b2_6'] = 'Je peux écrire une brève critique sur un film ou sur un livre.';
$string['elc_fr_wr_b2_7'] = 'Je peux exprimer, dans une lettre personnelle, différents sentiments et attitudes, raconter les dernières nouvelles et préciser ce qui pour moi est important dans un événement particulier.';
//$string['elc_fr_wr_b2_8'] = 'Ich kann selbstständig Seminararbeiten schreiben, muss sie aber von jemandem auf sprachliche Korrektheit und Angemessenheit hin überprüfen lassen. ';
//$string['elc_fr_wr_b2_9'] = 'Ich kann wissenschaftliche Texte aus meinem Fachgebiet für den späteren Gebrauch schriftlich zusammenfassen.';
$string['elc_fr_wr_b2_8'] = 'Je peux exposer un thème sous forme de rédaction ou de lettre de lecteur et présenter les arguments pour ou contre un point de vue.';

//Writing C1
$string['elc_fr_wr_c1_1'] = 'Je peux m’exprimer de manière claire tout à fait lisible sur une grande variété de sujets, professionnels ou généraux.';
$string['elc_fr_wr_c1_2'] = 'Je peux présenter un sujet complexe (par ex. dans un rapport de travail ou dans une rédaction) de manière claire et bien structurée et mettre en relief les points essentiels.';
$string['elc_fr_wr_c1_3'] = 'Je peux commenter un sujet ou un événement en exposant différents points de vue, en soulignant les idées principales et en illustrant mon raisonnement par des exemples détaillés.';
$string['elc_fr_wr_c1_4'] = 'Je peux rassembler des informations provenant de sources différentes et les résumer de manière cohérente par écrit.';
$string['elc_fr_wr_c1_5'] = 'Je peux décrire de manière détaillée des sentiments, des expériences et des événements dans des lettres personnelles.';
$string['elc_fr_wr_c1_6'] = 'Je peux écrire des lettres formellement correctes par ex. pour faire une réclamation ou pour prendre position pour ou contre un point de vue.';
$string['elc_fr_wr_c1_7'] = 'Je peux rédiger des textes très correctement et adapter mon vocabulaire et mon style au destinataire, au genre de texte et au sujet.';
$string['elc_fr_wr_c1_8'] = 'Je peux choisir, pour mes textes écrits, le style qui convient le mieux au lecteur.';
//$string['elc_fr_wr_c1_9'] = 'Ich verwende in meinen Texten ohne größere Probleme die Terminologie und Idiomatik meines Fachgebiets.';

//Writing C2
$string['elc_fr_wr_c2_1'] = 'Je peux écrire des rapports et des articles bien structurés et lisibles sur des sujets complexes.';
$string['elc_fr_wr_c2_2'] = 'Je peux exposer un thème que j’ai étudié dans un rapport ou un essai ; je peux résumer les opinions d’autres personnes, apporter des informations et des faits détaillés et les commenter.';
$string['elc_fr_wr_c2_3'] = 'Je peux écrire un commentaire clair et bien structuré sur un document de travail ou un projet et justifier mon opinion.';
$string['elc_fr_wr_c2_4'] = 'Je peux écrire une critique sur un événement culturel (film, musique, théâtre, littérature, radio, télévision).';
$string['elc_fr_wr_c2_5'] = 'Je peux résumer par écrit des textes factuels ou littéraires.';
$string['elc_fr_wr_c2_6'] = 'Je peux écrire des récits sur des expériences dans un style clair, fluide et approprié au genre choisi.';
$string['elc_fr_wr_c2_7'] = 'Je peux écrire une lettre formelle, même assez complexe, d’une manière claire et bien structurée, dans un style adéquat, par ex. une requête, une demande écrite, une offre aux autorités, à des supérieurs ou à des clients.';
$string['elc_fr_wr_c2_8'] = 'Je peux m’exprimer, dans mes lettres, d’une manière délibérément ironique, ambiguë ou humoristique.';
//$string['elc_fr_wr_c2_9'] = 'Ich kann mit Blick auf eine Veröffentlichung wissenschaftliche Texte in meinem Fachgebiet schreiben, die korrekt und stilistisch weitgehend angemessen sind. ';
//$string['elc_fr_wr_c2_10'] = 'Ich kann zu wissenschaftlichen Veröffentlichungen in meinem Fachgebiet eine zur Veröffentlichung bestimmte kritische Stellungnahme (z.B. Rezension) schreiben. ';
//$string['elc_fr_wr_c2_11'] = 'Ich kann im Verlauf eines Seminars, Tutoriums oder Kurses genaue und vollständige Aufzeichnungen machen. ';
//$string['elc_fr_wr_c2_12'] = 'Ich kann Informationen aus verschiedenen Quellen zusammenfassen und die Argumente und berichteten Sachverhalte so wiedergeben, dass insgesamt eine kohärente Darstellung entsteht. ';
//$string['elc_fr_wr_c2_13'] = 'Ich kann Texte von Kollegen überarbeiten und grammatisch und stilistisch verbessern; dabei habe ich nur selten Unsicherheiten.';

/* 
 * descriptors CercleS German
 */
 
$string['cercles_de_li_a1_1'] = 'Ich kann einfache Wörter und Ausdrücke über mich und meine Familie verstehen, wenn langsam und deutlich gesprochen wird.';
$string['cercles_de_li_a1_2'] = 'Ich kann einfache Aufforderungen, Hinweise und Bemerkungen verstehen.';
$string['cercles_de_li_a1_3'] = 'Ich kann die Bezeichnungen von alltäglichen Gegenständen in meiner direkten Umgebung verstehen.';
$string['cercles_de_li_a1_4'] = 'Ich kann Begrüßungsformeln und routinehafte Formeln verstehen (zum Beispiel: Bitte! Danke!).';
$string['cercles_de_li_a1_5'] = 'Ich kann einfache Fragen über mich verstehen, wenn langsam und deutlich gesprochen wird.';
$string['cercles_de_li_a1_6'] = 'Ich kann Zahlen und Preise verstehen.';
$string['cercles_de_li_a1_7'] = 'Ich kann die Wochentage und Monate verstehen.';
$string['cercles_de_li_a1_8'] = 'Ich kann die Uhrzeit und das Datum verstehen.';
$string['cercles_de_li_a2_1'] = 'Ich kann einfache alltägliche Gespräche verstehen, wenn langsam und deutlich gesprochen wird.';
$string['cercles_de_li_a2_2'] = 'Ich kann einfache alltägliche Wörter und Ausdrücke verstehen, die mit meiner unmittelbaren Situation zu tun haben (z.B. Familie, Studium, Umgebung, Arbeitsleben).';
$string['cercles_de_li_a2_3'] = 'Ich kann einfache alltägliche Wörter und Ausdrücke verstehen, die meine persönlichen Interessen betreffen (z.B. meine Hobbys, mein Sozialleben, Musik, Fernsehen, Film, Urlaubsreisen).';
$string['cercles_de_li_a2_4'] = 'Ich kann die Hauptpunkte von deutlichen und einfachen Durchsagen und Tonaufnahmen verstehen (am Telefon, am Bahnhof).';
$string['cercles_de_li_a2_5'] = 'Ich kann einfache Ausdrücke, Fragen und Informationen verstehen, die persönliche Bedürfnisse betreffen (z.B. beim Einkaufen, beim Essengehen, beim Arztbesuch).';
$string['cercles_de_li_a2_6'] = 'Ich kann einfache Wegbeschreibungen verstehen (z.B. wie man von A nach B kommt), zu Fuß und/oder mit öffentlichen Verkehrsmitteln.';
$string['cercles_de_li_a2_7'] = 'Ich kann normalerweise das Thema von Gesprächen um mich herum erkennen, wenn langsam und deutlich gesprochen wird.';
$string['cercles_de_li_a2_8'] = 'Ich kann Themenwechsel in Fernsehnachrichten erkennen und mir ein generelles Bild vom Inhalt machen.';
$string['cercles_de_li_a2_9'] = 'Ich kann die Hauptpunkte der Fernsehnachrichten zu Ereignissen, Unfällen usw. erkennen, wenn eine visuelle Unterstützung vorhanden ist.';
$string['cercles_de_li_b1_1'] = 'Ich kann einem Alltagsgespräch folgen, falls deutlich gesprochen und Standardsprache verwendet wird.';
$string['cercles_de_li_b1_2'] = 'Ich kann unkomplizierte Sachinformationen über gewöhnliche alltags-, studien- und berufsbezogene Themen verstehen und dabei die Hauptaussagen und Einzelinformationen erkennen, falls in einem vertrauten Akzent gesprochen wird.';
$string['cercles_de_li_b1_3'] = 'Ich kann die Hauptpunkte verstehen, wenn in deutlich artikulierter Standardsprache über vertraute Dinge gesprochen wird, denen man normalerweise im Alltag begegnet.';
$string['cercles_de_li_b1_4'] = 'Ich kann Vorträge oder Reden auf dem eigenen Fachgebiet verstehen, wenn die Thematik vertraut und die Darstellung unkompliziert und klar strukturiert ist.';
$string['cercles_de_li_b1_5'] = 'Ich kann in Radionachrichten und einfacheren Tonaufnahmen über vertraute Themen die Hauptpunkte verstehen, wenn relativ langsam und deutlich gesprochen wird.';
$string['cercles_de_li_b1_6'] = 'Ich kann vielen Fernsehprogrammen folgen, die von persönlichem oder kulturellem Interesse sind, wenn Standardsprache verwendet wird.';
$string['cercles_de_li_b1_7'] = 'Ich kann vielen Filmen folgen, in denen das Geschehen stark durch das Visuelle und die Handlung getragen wird, wenn Standardsprache verwendet wird.';
$string['cercles_de_li_b1_8'] = 'Ich kann detaillierten Wegbeschreibungen, Mitteilungen und Informationen folgen (z.B. Reiseinformationen, Wetterberichten, Anrufbeantwortern).';
$string['cercles_de_li_b1_9'] = 'Ich kann einfache technische Informationen verstehen, wie z.B. Bedienungsanleitungen für Geräte des täglichen Gebrauchs.';
$string['cercles_de_li_b2_1'] = 'Ich kann gesprochene Standardsprache in Alltagssituationen verstehen, wenn es um vertraute und auch weniger vertraute Themen geht, selbst bei Hintergrundgeräuschen.';
$string['cercles_de_li_b2_2'] = 'Ich kann mit einiger Anstrengung vieles verstehen, was in Gesprächen, die in meiner Gegenwart geführt werden, gesagt wird, würde aber Schwierigkeiten haben, mich wirklich an Gruppengesprächen mit Muttersprachlern zu beteiligen, die ihre Sprache in keiner Weise anpassen.';
$string['cercles_de_li_b2_3'] = 'Ich kann Ankündigungen und Mitteilungen zu konkreten und abstrakten Themen verstehen, die in normaler Geschwindigkeit in Standardsprache gegeben werden.';
$string['cercles_de_li_b2_4'] = 'Ich kann längeren Vorlesungen und Reden zu kulturellen, interkulturellen und sozialen Themen folgen, wenn Standardsprache verwendet wird (z.B. Gebräuche, Medien, Lebensstil, die EU).';
$string['cercles_de_li_b2_5'] = 'Ich kann längeren Redebeiträgen und komplexer Argumentation folgen, sofern die Thematik einigermaßen vertraut ist und der Rede- oder Gesprächsverlauf durch explizite Signale gekennzeichnet ist.';
$string['cercles_de_li_b2_6'] = 'Ich kann die Hauptaussagen von inhaltlich und sprachlich komplexen Vorlesungen, Reden, Berichten und anderen akademischen oder berufsbezogenen Präsentationen verstehen.';
$string['cercles_de_li_b2_7'] = 'Ich kann den meisten Fernsehnachrichten, Dokumentarfilmen, Interviews, Talkshows und Spielfilmen folgen, wenn Standardsprache verwendet wird.';
$string['cercles_de_li_b2_8'] = 'Ich kann den meisten Radioprogrammen und Tonaufnahmen folgen und die Stimmungslage, den Ton usw. der Sprechenden richtig erfassen, wenn Standardsprache verwendet wird.';
$string['cercles_de_li_b2_9'] = 'Ich kann Ausdrücke des Gefühls und Einstellungen einschätzen (z.B. kritisch, ironisch, zustimmend, gedankenlos, ablehnend).';
$string['cercles_de_li_c1_1'] = 'Ich kann längeren Reden und Gesprächen folgen, auch wenn diese nicht klar strukturiert sind und wenn Zusammenhänge nicht explizit ausgedrückt werden.';
$string['cercles_de_li_c1_2'] = 'Ich kann ein breites Spektrum idiomatischer Wendungen und umgangssprachlicher Ausdrucksformen verstehen und Registerwechsel richtig einschätzen.';
$string['cercles_de_li_c1_3'] = 'Ich kann genug verstehen, um längeren Redebeiträgen über nicht vertraute, abstrakte und komplexe Themen zu folgen, wenn auch gelegentlich Details bestätigt werden müssen, insbesondere bei fremdem Akzent.';
$string['cercles_de_li_c1_4'] = 'Ich kann komplexer Interaktion Dritter in Gruppendiskussionen oder Debatten leicht folgen, auch wenn abstrakte, komplexe, nicht vertraute Themen behandelt werden.';
$string['cercles_de_li_c1_5'] = 'Ich kann die meisten Vorlesungen, Diskussionen und Debatten meines Studien- und/oder Berufsfeldes relativ leicht verstehen.';
$string['cercles_de_li_c1_6'] = 'Ich kann komplexe technische Informationen verstehen, z. B. Bedienungsanleitungen oder Spezifikationen zu vertrauten Produkten und Dienstleistungen.';
$string['cercles_de_li_c1_7'] = 'Ich kann auch bei schlechter Übertragungsqualität aus öffentlichen Durchsagen (z. B. am Bahnhof oder bei Sportveranstaltungen) Einzelinformationen heraushören.';
$string['cercles_de_li_c1_8'] = 'Ich kann ein breites Spektrum an Tonaufnahmen und Radiosendungen verstehen, auch wenn nicht unbedingt Standardsprache gesprochen wird, und kann dabei feinere Details sowie implizite Einstellungen oder Beziehungen zwischen den Sprechern erkennen.';
$string['cercles_de_li_c1_9'] = 'Ich kann Filmen folgen, die einen hohen Anteil von Umgangssprache verwenden.';
$string['cercles_de_li_c2_1'] = 'Ich habe keinerlei Schwierigkeiten, alle Arten gesprochener Sprache zu verstehen, sei dies im direkten Gepräch oder in den Medien, und zwar auch wenn schnell gesprochen wird, wie Muttersprachler dies tun.';
$string['cercles_de_li_c2_2'] = 'Ich kann Fachvorträge oder Präsentationen verstehen, die viele umgangssprachliche oder regional gefärbte Ausdrücke oder auch fremde Terminologie enthalten.';
$string['cercles_de_re_a1_1'] = 'Ich kann vertraute Namen, Wörter und Wendungen in einfachen und kurzen Texten erkennen.';
$string['cercles_de_re_a1_2'] = 'Ich kann Wörter und Wendungen des Alltagslebens auf einfachen Hinweisen und Schildern verstehen (z.B. “Ausgang”, “Rauchen verboten”, “Gefahr”, die Wochentage, die Tageszeit).';
$string['cercles_de_re_a1_3'] = 'Ich kann einfache Formulare so weit verstehen, dass ich einfache persönliche Angaben machen kann (z.B. meinen Namen, meine Adresse und mein Geburtsdatum).';
$string['cercles_de_re_a1_4'] = 'Ich kann einfache schriftliche Mitteilungen und Kommentare verstehen, die sich auf mein Studium beziehen (z.B. „gut gemacht“, „bitte überarbeiten“).';
$string['cercles_de_re_a1_5'] = 'Ich kann kurze und einfache Mitteilungen auf Gruß- und Postkarten verstehen (z.B. Urlaubsgrüße, Geburtstagsgrüße).';
$string['cercles_de_re_a1_6'] = 'Ich kann mir bei einfacherem Informationsmaterial eine Vorstellung vom Inhalt machen, besonders wenn es visuelle Hilfen gibt (z.B. Poster, Kataloge, Werbung).';
$string['cercles_de_re_a1_7'] = 'Ich kann kurze, einfache schriftliche Wegerklärungen verstehen (z.B. um von A nach B zu kommen).';
$string['cercles_de_re_a2_1'] = 'Ich kann kurze, einfache Texte zu vertrauten konkreten Themen verstehen, in denen gängige alltags- oder berufsbezogene Sprache verwendet wird.';
$string['cercles_de_re_a2_2'] = 'Ich kann gebräuchliche Zeichen und Schilder an öffentlichen Orten verstehen (z.B. auf Straßen, in Läden, Hotels, oder Bahnstationen).';
$string['cercles_de_re_a2_3'] = 'Ich kann konkrete, voraussagbare Informationen in einfachen Alltagstexten auffinden, z.B. in Anzeigen, Fahrplänen, Speisekarten, Verzeichnissen und Prospekten.';
$string['cercles_de_re_a2_4'] = 'Ich kann Anleitungen verstehen, wenn sie in einfacher Sprache formuliert sind (z.B. öffentliches Telefon).';
$string['cercles_de_re_a2_5'] = 'Ich kann Vorschriften, z.B. Sicherheitsvorschriften oder solche für die Teilnahme an Vorlesungen, verstehen, wenn sie in einfacher Sprache formuliert sind.';
$string['cercles_de_re_a2_6'] = 'Ich kann kurze, einfache Privatbriefe verstehen, die Informationen geben oder erfragen oder die eine Einladung enthalten.';
$string['cercles_de_re_a2_7'] = 'Ich kann aus kurzen Zeitungs- oder Zeitschriftenberichten, die Geschichten oder Ereignisse wiedergeben, wesentliche Informationen herausfinden.';
$string['cercles_de_re_a2_8'] = 'Ich kann die Grundinformationen in Routinebriefen und -nachrichten verstehen (z.B. Hotelreservierungen, Telefonnotizen).';
$string['cercles_de_re_b1_1'] = 'Ich kann unkomplizierte Sachtexte über Themen, die mit den eigenen Interessen und Fachgebieten in Zusammenhang stehen, zufriedenstellend und ausreichend verstehen.';
$string['cercles_de_re_b1_2'] = 'Ich kann in unkomplizierten Zeitungsartikeln zu vertrauten Themen die wesentlichen Punkte erfassen.';
$string['cercles_de_re_b1_3'] = 'Ich kann in klar geschriebenen argumentativen Texten zu meinem Fachgebiet oder Beruf die wesentlichen Schlussfolgerungen erkennen.';
$string['cercles_de_re_b1_4'] = 'Ich kann die Beschreibung von Ereignissen, Gefühlen und Wünschen in privaten Briefen und E-Mails hinreichend verstehen, um regelmäßig mit einem Brieffreund/ einer Brieffreundin korrespondieren zu können.';
$string['cercles_de_re_b1_5'] = 'Ich kann in einfachen Alltagstexten wie Briefen, Informationsbroschüren und kurzen offiziellen Dokumenten wichtige Informationen auffinden und verstehen.';
$string['cercles_de_re_b1_6'] = 'Ich kann klar formulierte, unkomplizierte Anleitungen verstehen (z.B. zur Bedienung eines Geräts, für das Beantworten von Prüfungsfragen).';
$string['cercles_de_re_b1_7'] = 'Ich kann längere Texte nach gewünschten Informationen durchsuchen und Informationen aus verschiedenen Texten oder Textteilen zusammentragen, um eine bestimmte Aufgabe zu lösen.';
$string['cercles_de_re_b1_8'] = 'Ich kann der Handlung von klar strukturierten Erzählungen und modernen literarischen Texten folgen.';
$string['cercles_de_re_b2_1'] = 'Ich kann lange und komplexe Texte zu unterschiedlichen Themen meines Feldes rasch durchsuchen und wichtige Einzelinformationen auffinden.';
$string['cercles_de_re_b2_2'] = 'Ich kann Korrespondenz lesen, die sich auf das eigene Interessengebiet bezieht, und leicht die wesentliche Aussage erfassen.';
$string['cercles_de_re_b2_3'] = 'Ich kann aus hoch spezialisierten Quellen des eigenen Fachgebiets Informationen, Gedanken und Meinungen entnehmen.';
$string['cercles_de_re_b2_4'] = 'Ich kann Fachartikel, die über das eigene Gebiet hinausgehen, lesen und verstehen, wenn ich ein Wörterbuch oder andere Nachschlagewerke benutzen kann.';
$string['cercles_de_re_b2_5'] = 'Ich kann rasch den Inhalt und die Wichtigkeit von Nachrichten, Artikeln und Berichten zu einem breiten Spektrum berufsbezogener Themen erfassen und entscheiden, ob sich ein genaueres Lesen lohnt.';
$string['cercles_de_re_b2_6'] = 'Ich kann Artikel und Berichte zu aktuellen Fragen lesen und verstehen, in denen die Schreibenden eine bestimmte Haltung oder einen bestimmten Standpunkt vertreten.';
$string['cercles_de_re_b2_7'] = 'Ich kann lange, komplexe Anleitungen im eigenen Fachgebiet verstehen, auch detaillierte Vorschriften oder Warnungen, sofern schwierige Passagen mehrmals gelesen werden können.';
$string['cercles_de_re_b2_8'] = 'Ich kann ohne Schwierigkeiten die meisten Erzählungen und moderne literarische Texte erschließen (z.B. Romane, Kurzgeschichten, Gedichte, Dramen).';
$string['cercles_de_re_c1_1'] = 'Ich kann hoch spezialisierte Texte in meinem Studien- oder Berufsgebiet verstehen, wie z.B. Forschungsberichte und Abstracts.';
$string['cercles_de_re_c1_2'] = 'Ich kann unter gelegentlicher Zuhilfenahme des Wörterbuchs jegliche Korrespondenz verstehen.';
$string['cercles_de_re_c1_3'] = 'Ich kann ohne Probleme zeitgenössische literarische Texte lesen und auch implizite Einstellungen und Meinungen erfassen.';
$string['cercles_de_re_c1_4'] = 'Ich kann den sozio-historischen und politischen Kontext der meisten literarischen Werke erfassen.';
$string['cercles_de_re_c1_5'] = 'Ich kann lange, komplexe Anleitungen für neue Geräte oder neue Verfahren auch außerhalb des eigenen Fachgebietes im Detail verstehen, sofern schwierige Passagen mehrmals gelesen werden können.';
$string['cercles_de_re_c2_1'] = 'Ich kann ein breites Spektrum langer und komplexer Texte verstehen und dabei feine stilistische Unterschiede und implizite Bedeutungen erfassen.';
$string['cercles_de_re_c2_2'] = 'Ich kann praktisch alle Arten geschriebener Texte verstehen und kritisch interpretieren, einschließlich abstrakter, strukturell komplexer oder stark umgangssprachlicher literarischer oder nicht-literarischer Texte.';
$string['cercles_de_re_c2_3'] = 'Ich kann von komplexen, technischen oder hochspezialisierten Texte effektiven Gebrauch machen für meine akademischen oder berufsbezogenen Zwecke.';
$string['cercles_de_re_c2_4'] = 'Ich kann zeitgenössische und klassische literarische Texte verschiedener Gattungen kritisch einschätzen.';
$string['cercles_de_re_c2_5'] = 'Ich kann die feineren Bedeutungsnuancen von Ausdrücken, rhetorischen und anderen Stilmitteln in kritischen oder satirischen Texten erkennen.';
$string['cercles_de_re_c2_6'] = 'Ich kann komplexe Sachtexte wie technische Handbücher und rechtliche Verträge verstehen.';
$string['cercles_de_wr_a1_1'] = 'Ich kann ein einfaches Formular oder einen Fragebogen mit Einzelheiten zu meiner Person ausfüllen (z.B. Geburtsdatum, Adresse, Nationalität).';
$string['cercles_de_wr_a1_2'] = 'Ich kann eine einfache Postkarte oder Grußkarte schreiben.';
$string['cercles_de_wr_a1_3'] = 'Ich kann einfache Wendungen und Sätze über mich selbst schreiben (z.B. wo ich lebe, wieviele Geschwister ich habe).';
$string['cercles_de_wr_a1_4'] = 'Ich kann eine kurze einfache Notiz oder Nachricht schreiben (z.B. jemandem mitteilen, wo ich bin oder wo man sich trifft).';
$string['cercles_de_wr_a2_1'] = 'Ich kann kurze einfache Notizen oder Nachrichten schreiben (z.B. dass jemand angerufen hat, ein Treffen vereinbaren, meine Abwesenheit erklären).';
$string['cercles_de_wr_a2_2'] = 'Ich kann einen Fragebogen ausfüllen oder einen einfachen Lebenslauf mit Einzelheiten zu meiner Person schreiben.';
$string['cercles_de_wr_a2_3'] = 'Ich kann in Form einfacher verbundener Sätze etwas über alltägliche Aspekte des eigenen Umfelds schreiben (z.B. Familie, Universitätsleben, Ferien, Berufserfahrungen).';
$string['cercles_de_wr_a2_4'] = 'Ich kann kurze, einfache fiktive Biographien und Geschichten über Menschen schreiben.';
$string['cercles_de_wr_a2_5'] = 'Ich kann sehr kurze, elementare Beschreibungen von Ereignissen, vergangenen Handlungen und persönlichen Erfahrungen verfassen.';
$string['cercles_de_wr_a2_6'] = 'Ich kann einen kurzen persönlichen Brief mit angemessenen Worten und Grußformen einführen und beschließen.';
$string['cercles_de_wr_a2_7'] = 'Ich kann einen sehr einfachen persönlichen Brief schreiben (z.B. eine Einladung annehmen oder ablehnen, jemandem für etwas danken, mich entschuldigen).';
$string['cercles_de_wr_a2_8'] = 'Ich kann einen einfachen formellen Brief mit angemessenen Worten und Grußformen einführen und beschließen.';
$string['cercles_de_wr_a2_9'] = 'Ich kann sehr einfache formelle Briefe schreiben, in denen ich um Informationen bitte (z.B. zu Ferienarbeit, zu Hotelunterbringung).';
$string['cercles_de_wr_b1_1'] = 'Ich kann eine Beschreibung eines realen oder fiktiven Ereignisses verfassen (z.B. eine vor kurzem stattgefundene Urlaubsreise).';
$string['cercles_de_wr_b1_2'] = 'Ich kann Notizen mit einfachen Informationen verfassen, die für Personen meines alltäglichen Lebensumfeldes relevant sind und kann dabei die Punkte vermitteln, die mir besonders wichtig sind.';
$string['cercles_de_wr_b1_3'] = 'Ich kann persönliche Briefe schreiben und dabei über Neuigkeiten, Erfahrungen und Eindrücke berichten sowie Gefühle ausdrücken.';
$string['cercles_de_wr_b1_4'] = 'Ich kann Nachrichten zu Anfragen und Sachinformationen aufschreiben und dabei Probleme erklären.';
$string['cercles_de_wr_b1_5'] = 'Ich kann unkomplizierte, zusammenhängende Texte zu vertrauten Themen aus meinem Interessengebiet verfassen, wobei einzelne kürzere Teile in linearer Abfolge verbunden werden und Wörterbücher und andere Nachschlagewerke benutzt werden.';
$string['cercles_de_wr_b1_6'] = 'Ich kann die Handlung eines Films oder Buchs beschreiben oder eine einfache Geschichte erzählen.';
$string['cercles_de_wr_b1_7'] = 'Ich kann in einem üblichen Standardformat sehr kurze Berichte abfassen, in denen Sachinformationen zu meinem Fachgebiet weitergegeben werden.';
$string['cercles_de_wr_b1_8'] = 'Ich kann im eigenen Fachgebiet mit einer gewissen Sicherheit umfangreichere Sachinformationen über vertraute Themen zusammenfassen, darüber berichten und dazu Stellung nehmen.';
$string['cercles_de_wr_b1_9'] = 'Ich kann Standardbriefe schreiben, um detaillierte Informationen zu ver- bzw. ermitteln (z.B. auf eine Anzeige antworten, mich auf eine Stelle bewerben).';
$string['cercles_de_wr_b2_1'] = 'Ich kann unkomplizierte, zusammenhängende Texte zu einem Spektrum vertrauter Themen aus meinen persönlichen, studien- oder berufsbezogenen Interessensgebieten verfassen.';
$string['cercles_de_wr_b2_2'] = 'Ich kann Briefe schreiben, in denen ich meine Gefühle differenziert beschreibe, die persönliche Bedeutung von Ereignissen und Erfahrungen hervorhebe und die Nachrichten und Standpunkte meines Briefpartners kommentiere.';
$string['cercles_de_wr_b2_3'] = 'Ich kann Neuigkeiten, Standpunkte, und Gefühle erfolgreich schriftlich darstellen und zu denen anderer Stellung nehmen.';
$string['cercles_de_wr_b2_4'] = 'Ich kann Artikel zu persönlichen, studien- oder berufsbezogenen Themen sowie Sachinformationen aus verschiedenen Quellen und Medien zusammenfassen.';
$string['cercles_de_wr_b2_5'] = 'Ich kann in einem Aufsatz oder Bericht etwas erörtern, dabei Gründe für oder gegen einen bestimmten Standpunkt angeben und die Vor- und Nachteile verschiedener Optionen abwägen.';
$string['cercles_de_wr_b2_6'] = 'Ich kann Informationen und Argumente aus verschiedenen Quellen zusammenfassen und zusammenführen.';
$string['cercles_de_wr_b2_7'] = 'Ich kann eine kurze Rezension eines Films oder Buchs schreiben.';
$string['cercles_de_wr_b2_8'] = 'Ich kann in leicht lesbarer Form klare, detaillierte, zusammenhängende Beschreibungen realer oder fiktiver Ereignisse und Erfahrungen verfassen und dabei den Zusammenhang zwischen verschiedenen Ideen deutlich machen.';
$string['cercles_de_wr_b2_9'] = 'Ich kann standardisierte offizielle Briefe schreiben, in denen ich relevante Informationen angebe oder erfrage, unter Verwendung des angemessenen Registers und unter Beachtung der Gepflogenheiten.';
$string['cercles_de_wr_c1_1'] = 'Ich kann mich flüssig und korrekt zu einer Vielzahl von persönlichen, studien- und berufsbezogenen Themen schriftlich ausdrücken und dabei mein Vokabular und meinen Stil dem Kontext anpassen.';
$string['cercles_de_wr_c1_2'] = 'Ich kann mich in meinen persönlichen Briefen klar und genau ausdrücken und dabei Sprache flexibel und wirksam einsetzen, auch beim Gebrauch von Emotionen, Anspielungen und Scherzen.';
$string['cercles_de_wr_c1_3'] = 'Ich kann klare, gut strukturierte Texte zu komplexen Themen in meinem Fachgebiet verfassen und dabei die entscheidenden Punkte hervorheben, Standpunkte ausführlich darstellen und durch Unterpunkte oder geeignete Beispiele oder Begründungen stützen sowie den Text durch einen angemessenen Schluss abrunden.';
$string['cercles_de_wr_c1_4'] = 'Ich kann klare, detaillierte, gut strukturierte und ausführliche Beschreibungen oder auch eigene fiktionale Texte in lesergerechtem, überzeugendem, persönlichem und natürlichem Stil verfassen.';
$string['cercles_de_wr_c1_5'] = 'Ich kann in komplexen formellen Briefen meine Argumente wirkungsvoll und korrekt darlegen (z.B. eine Beschwerde vorbringen, eine kontroverse Stellung zu einer Problemfrage beziehen).';
$string['cercles_de_wr_c2_1'] = 'Ich kann zu meinem Studien- oder Berufsgebiet klare, flüssige, komplexe Texte in angemessenem und effektivem Stil schreiben, deren logische Struktur den Lesern das Auffinden der wesentlichen Punkte erleichtert.';
$string['cercles_de_wr_c2_2'] = 'Ich kann klare, flüssige und fesselnde Geschichten und Beschreibungen von Erfahrungen verfassen, in einem Stil, der dem gewählten Genre angemessenen ist.';
$string['cercles_de_wr_c2_3'] = 'Ich kann eine gut strukturierte kritische Rezension eines Fachartikels, Projekts oder Antrags zu meinem Fach- oder Berufsgebiet schreiben und dabei meine Meinung begründen.';
$string['cercles_de_wr_c2_4'] = 'Ich kann klare, flüssige, komplexe Berichte, Artikel oder Aufsätze verfassen, in denen ein Fall dargestellt oder ein Argument entwickelt wird.';
$string['cercles_de_wr_c2_5'] = 'Ich kann Texten einen angemessenen, effektiven logischen Aufbau geben, der den Lesenden hilft, die wesentlichen Punkte zu finden.';
$string['cercles_de_wr_c2_6'] = 'Ich kann detaillierte kritische Rezensionen von kulturellen Ereignissen oder literarischen Werken verfassen.';
$string['cercles_de_wr_c2_7'] = 'Ich kann überzeugende, gut strukturierte und komplexe formelle Briefe in einem angemessenen Stil schreiben.';
$string['cercles_de_sp_a1_1'] = 'Ich kann einfache Angaben zu meiner Person machen (z.B. mein Alter, meine Familie, meine Studienfächer).';
$string['cercles_de_sp_a1_2'] = 'Ich kann mit einfachen Worten beschreiben, wo ich wohne.';
$string['cercles_de_sp_a1_3'] = 'Ich kann mit einfachen Worten Personen beschreiben, die ich kenne.';
$string['cercles_de_sp_a1_4'] = 'Ich kann ein kurzes, eingeübtes Statement verlesen (z.B. einen Redner vorstellen, einen Toast ausbringen).';
$string['cercles_de_sp_a2_1'] = 'Ich kann mich, meine Familie und andere Personen, die ich kenne, beschreiben.';
$string['cercles_de_sp_a2_2'] = 'Ich kann meine Wohnung beschreiben und erklären, wo ich wohne.';
$string['cercles_de_sp_a2_3'] = 'Ich kann sagen, was ich normalerweise zu Hause, an der Universität und in meiner Freizeit mache.';
$string['cercles_de_sp_a2_4'] = 'Ich kann meine schulische Ausbildung und meine Studienfächer beschreiben.';
$string['cercles_de_sp_a2_5'] = 'Ich kann Pläne, Vereinbarungen und Alternativvorschläge beschreiben.';
$string['cercles_de_sp_a2_6'] = 'Ich kann in kurzen und einfachen Worten Erlebnisse und kurze Geschichten beschreiben.';
$string['cercles_de_sp_a2_7'] = 'Ich kann vergangene Aktivitäten und persönliche Erlebnisse beschreiben (z.B. was ich am Wochenende gemacht habe).';
$string['cercles_de_sp_a2_8'] = 'Ich kann erklären, was ich an etwas mag oder nicht mag.';
$string['cercles_de_sp_a2_9'] = 'Ich kann mit einfachen Mitteln Dinge beschreiben und vergleichen.';
$string['cercles_de_sp_a2_10'] = 'Ich kann sehr kurze, eingeübte Ankündigungen mit vorhersehbarem, auswendig gelerntem Inhalt vortragen.';
$string['cercles_de_sp_a2_11'] = 'Ich kann eine kurze, eingeübte Präsentation zu einem Thema aus meinem Fachgebiet oder Berufsfeld vortragen.';
$string['cercles_de_sp_b1_1'] = 'Ich kann relativ flüssig eine zusammenhängende Beschreibung zu Themen aus meinem Studium oder Berufsfeld geben, soweit die einzelnen Punkte linear aneinandergereiht werden.';
$string['cercles_de_sp_b1_2'] = 'Ich kann eine Geschichte erzählen oder die Handlung eines Films oder eines Buchs wiedergeben.';
$string['cercles_de_sp_b1_3'] = 'Ich kann über eigene Erfahrungen und Reaktionen berichten, Träume, Hoffnungen und Ziele beschreiben, reale, erfundene und unvorhergesehene Ereignisse schildern.';
$string['cercles_de_sp_b1_4'] = 'Ich kann für Ansichten, Pläne oder Handlungen kurze Begründungen oder Erklärungen geben.';
$string['cercles_de_sp_b1_5'] = 'Ich kann eine Argumentation so ausführen, dass sie in der Regel ohne Schwierigkeiten verstanden werden kann.';
$string['cercles_de_sp_b1_6'] = 'Ich kann eine einfache Zusammenfassung von kurzen schriftlichen Texten vortragen.';
$string['cercles_de_sp_b1_7'] = 'Ich kann detailliert über Probleme und Ereignisse berichten (z.B. einen Diebstahl, einen Verkehrsunfall).';
$string['cercles_de_sp_b1_8'] = 'Ich kann kurze, eingeübte Ankündigungen zu alltäglichen Ereignissen aus dem eigenen Erfahrungsgebiet vortragen.';
$string['cercles_de_sp_b1_9'] = 'Ich kann eine vorbereitete, unkomplizierte Präsentation zu einem vertrauten Thema aus meinem Fachgebiet oder Berufsfeld in hinreichend präziser und klarer Form vortragen.';
$string['cercles_de_sp_b2_1'] = 'Ich kann eine große Bandbreite von Themen aus meinem Arbeits- und Interessengebiet klar und systematisch beschreiben und darstellen und dabei wichtige Punkte mit ergänzenden Informationen und relevanten Beispielen erweitern und untermauern.';
$string['cercles_de_sp_b2_2'] = 'Ich kann einen Standpunkt zu einer aktuellen Problemstellung erklären und die Vor- und Nachteile verschiedener Alternativen angeben.';
$string['cercles_de_sp_b2_3'] = 'Ich kann eine klare zusammenhängende Argumentationslinie darstellen, mit logischer Gedankenverbindung sowie Erweiterung und Unterstützung meiner Gesichtspunkte durch treffende Beispiele.';
$string['cercles_de_sp_b2_4'] = 'Ich kann eine Frage oder ein Problem klar umreißen und über Gründe, Konsequenzen sowie hypothetische Situationen spekulieren.';
$string['cercles_de_sp_b2_5'] = 'Ich kann kurze Gespräche und Erzählungen mündlich zusammenfassen (z.B. Texte, Radio- und Fernsehsendungen).';
$string['cercles_de_sp_b2_6'] = 'Ich kann Ankündigungen zu den meisten allgemeinen Themen so klar, spontan und flüssig vortragen, dass man ihnen ohne große Mühe folgen kann.';
$string['cercles_de_sp_b2_7'] = 'Ich kann eine klare und systematisch angelegte Präsentation zu einem Thema meines Feldes vortragen und dabei wesentliche Punkte und relevante unterstützende Details hervorheben.';
$string['cercles_de_sp_b2_8'] = 'Ich kann spontan vom vorbereiteten Text abweichen und vom Publikum aufgeworfene Fragen aufgreifen.';
$string['cercles_de_sp_c1_1'] = 'Ich kann komplexe Sachverhalte in meinem Fachgebiet klar und detailliert beschreiben.';
$string['cercles_de_sp_c1_2'] = 'Ich kann Sachverhalte ausführlich beschreiben und Geschichten erzählen, kann untergeordnete Themen integrieren, bestimmte Punkte genauer ausführen und alles mit einem angemessenen Schluss abrunden.';
$string['cercles_de_sp_c1_3'] = 'Ich kann lange und komplexe Texte zu meinem Fachgebiet detailliert mündlich zusammenfassen.';
$string['cercles_de_sp_c1_4'] = 'Ich kann beinahe mühelos öffentliche Ankündigungen vortragen und dabei durch Betonung und Intonation auch feinere Bedeutungsnuancen deutlich machen.';
$string['cercles_de_sp_c1_5'] = 'Ich kann ein komplexes Thema meines Fachgebiets gut strukturiert und klar vortragen, dabei die eigenen Standpunkte ausführlich darstellen und durch Unterpunkte, geeignete Beispiele oder Begründungen stützen.';
$string['cercles_de_sp_c2_1'] = 'Ich kann klar, flüssig und gut strukturiert sprechen und meinen Beitrag so logisch aufbauen, dass es den Zuhörern erleichtert wird, wichtige Punkte wahrzunehmen und zu behalten.';
$string['cercles_de_sp_c2_2'] = 'Ich kann Sachverhalte klar, flüssig, ausführlich und oft leicht behaltbar beschreiben.';
$string['cercles_de_sp_c2_3'] = 'Ich kann Informationen und Ideen aus verschiedenen spezialisierten Quellen meines Fachgebiets klar und flexibel zusammenfassen und integrieren.';
$string['cercles_de_sp_c2_4'] = 'Ich kann sicher und gut verständlich einem Publikum ein komplexes Thema vortragen, und kann mit schwierigen und auch aggressiven Fragen umgehen.';
$string['cercles_de_si_a1_1'] = 'Ich kann einfache Gruß- und Abschiedsformeln sowie alltägliche Ausdrücke gebrauchen (z.B. bitte, danke), jemanden nach dem Befinden fragen und mitteilen, wie mein Befinden ist.';
$string['cercles_de_si_a1_2'] = 'Ich kann mich und andere vorstellen und jemanden nach dem Namen fragen.';
$string['cercles_de_si_a1_3'] = 'Ich kann sagen, dass ich etwas nicht verstehe, dass man etwas wiederholen oder langsamer sprechen soll. Ich kann die Aufmerksamkeit hierauf lenken und um Hilfe bitten.';
$string['cercles_de_si_a1_4'] = 'Ich kann fragen, wie man etwas in der Fremdsprache sagt oder nach der Bedeutung eines Wortes fragen.';
$string['cercles_de_si_a1_5'] = 'Ich kann einfache direkte Fragen stellen und beantworten, die sich auf alltägliche Themen beziehen (z.B. Familie, Studentenleben), ggf. mit Hilfe der Person, mit der ich spreche.';
$string['cercles_de_si_a1_6'] = 'Ich kann jemanden um etwas bitten und jemandem etwas geben.';
$string['cercles_de_si_a1_7'] = 'Ich komme mit Zahlen, Mengenangaben, Preisen und Zeitangaben zurecht.';
$string['cercles_de_si_a1_8'] = 'Ich kann einfache Einkäufe erledigen, indem ich durch Zeigen und Gestik unterstütze, was ich sage.';
$string['cercles_de_si_a1_9'] = 'Ich kann in einem Gespräch einfache, direkte Fragen zur Person beantworten, wenn die Fragen langsam, deutlich und in Standardsprache gestellt werden.';
$string['cercles_de_si_a2_1'] = 'Ich kann einfache sprachliche soziale Interaktionen bewältigen und mich verständlich machen, wenn man mir hilft.';
$string['cercles_de_si_a2_2'] = 'Ich kann an kurzen Gesprächen in Routinekontexten zu Themen meines Interesses teilnehmen.';
$string['cercles_de_si_a2_3'] = 'Ich kann Personen einladen und auf Einladungen reagieren, Vorschläge machen, mich entschuldigen und um Erlaubnis bitten.';
$string['cercles_de_si_a2_4'] = 'Ich kann sagen, was ich mag und was nicht, kann meine Zustimmung und Ablehnung äußern und Vergleiche anstellen.';
$string['cercles_de_si_a2_5'] = 'Ich kann mit einfachen Worten ausdrücken, wie es mir geht und kann mich bedanken.';
$string['cercles_de_si_a2_6'] = 'Ich kann besprechen, was man unternehmen möchte, wo es hingehen soll, und eine Verabredung treffen (z.B. am Abend, am Wochenende).';
$string['cercles_de_si_a2_7'] = 'Ich kann zu alltäglichen Themen Fragen stellen und Antworten geben (z.B. Wetter, Hobbys, Sozialleben, Musik, Sport).';
$string['cercles_de_si_a2_8'] = 'Ich kann zu Ereignissen in der Vergangenheit Fragen stellen und Antworten geben (z.B. gestern, letzte Woche, letztes Jahr).';
$string['cercles_de_si_a2_9'] = 'Ich kann einfache Telefonanrufe bewältigen (ich kann z.B. sagen, wer am Apparat ist, darum bitten, mit jemandem zu sprechen, meine Nummer angeben, eine einfache Nachricht entgegennehmen).';
$string['cercles_de_si_a2_10'] = 'Ich kann einfache Transaktionen durchführen (z.B. in einem Geschäft, der Post, am Bahnhof) und etwas zu Essen und Trinken bestellen.';
$string['cercles_de_si_a2_11'] = 'Ich kann einfache praktische Informationen einholen (z.B. Wegbeschreibungen, Reservierungen, Arztbesuche).';
$string['cercles_de_si_b1_1'] = 'Ich kann an einer Unterhaltung zu den meisten Themen über vertraute Routineangelegenheiten teilnehmen und meistens das richtige Register verwenden.';
$string['cercles_de_si_b1_2'] = 'Ich kann eine längere Unterhaltung oder Diskussion in Gang halten, aber benötige manchmal etwas Hilfe, um meine Gedanken zu formulieren.';
$string['cercles_de_si_b1_3'] = 'Ich kann an einer formellen Diskussion zu vertrauten Themen meines Fach- oder Berufsgebiets teilnehmen, wenn deutlich gesprochen und Standardsprache verwendet wird.';
$string['cercles_de_si_b1_4'] = 'Ich kann mit einiger Sicherheit Informationen über mein Fach- oder Berufsgebiet austauschen, sie prüfen und bestätigen.';
$string['cercles_de_si_b1_5'] = 'Ich kann Gefühle und Einstellungen ausdrücken und auf sie reagieren (z.B. Überraschung, Freude, Traurigkeit, Interesse, Unsicherheit, Gleichgültigkeit).';
$string['cercles_de_si_b1_6'] = 'Ich kann höflich meine Zustimmung oder Ablehnung ausdrücken und persönliche Entscheidungen und Ideen vertreten.';
$string['cercles_de_si_b1_7'] = 'Ich kann meine Gedanken über abstrakte oder kulturelle Themen ausdrücken, wie Film oder Musik, und kurze Kommentare zu den Meinungen anderer abgeben.';
$string['cercles_de_si_b1_8'] = 'Ich kann erklären, warum etwas ein Problem darstellt, diskutieren, was als nächstes zu tun ist und Alternativen abwägen.';
$string['cercles_de_si_b1_9'] = 'Ich kann detaillierte Informationen, Mitteilungen, Anweisungen und Erläuterungen einholen sowie nach detaillierten Anweisungen fragen und ihnen folgen.';
$string['cercles_de_si_b1_10'] = 'Ich kann die meisten Alltagssituationen bewältigen (z.B. telefonisch Informationen einholen, um Rückerstattung bitten, einen Einkauf tätigen).';
$string['cercles_de_si_b1_11'] = 'Ich kann konkrete Angaben machen, die in einem Gespräch/ einer Beratung erfragt werden (z.B. einem Arzt Symptome beschreiben), wenn auch nur ungenau.';
$string['cercles_de_si_b1_12'] = 'Ich kann in einem Gespräch/ einer Beratung die Initiative ergreifen (z.B. ein neues Thema einbringen), aber ich bin auf die Unterstützung meines Gesprächspartners angewiesen.';
$string['cercles_de_si_b1_13'] = 'Ich kann einen vorbereiteten Fragebogen benutzen, um ein strukturiertes Interview durchzuführen, und kann zusätzliche spontane Fragen stellen.';
$string['cercles_de_si_b2_1'] = 'Ich kann mich vollständig an Gesprächen zu allgemeinen Themen beteiligen, mich dabei spontan und fließend verständigen und angemessene Register benutzen.';
$string['cercles_de_si_b2_2'] = 'Ich kann effektiv an längeren Gesprächen über ein breites Spektrum persönlicher, wissenschaftlicher und beruflicher Themen teilnehmen und dabei die Zusammenhänge zwischen Ideen deutlich machen.';
$string['cercles_de_si_b2_3'] = 'Ich kann meine Meinung in einer Diskussion ausdrücken und erläutern, indem ich Erklärungen, Argumente und Kommentare einbringe.';
$string['cercles_de_si_b2_4'] = 'Ich kann Gefühle, Einstellungen, Meinungen und Standpunkte differenziert ausdrücken und mit entsprechendem Tonfall auf sie reagieren.';
$string['cercles_de_si_b2_5'] = 'Ich kann detaillierte Fakten zu meinem Studienfach oder Berufsfeld austauschen.';
$string['cercles_de_si_b2_6'] = 'Ich kann den Fortschritt eines Projekts beschleunigen, indem ich andere zur Teilnahme auffordere, sie um ihre Meinung bitte, etc.';
$string['cercles_de_si_b2_7'] = 'Ich kann sprachlich Situationen bewältigen, in denen es um potentiell komplexe Probleme in Alltagssituationen geht (z.B. mich über Waren und Dienstleistungen beschweren).';
$string['cercles_de_si_b2_8'] = 'Ich kann in sprachlich angemesser Form Notfälle bewältigen (z.B. einen Notarzt rufen, die Polizei rufen oder den Pannendienst benachrichtigen).';
$string['cercles_de_si_b2_9'] = 'Ich kann ohne Probleme ein Interview bewältigen und kann ohne viele Hilfen oder Anstöße des Interviewers die Initiative ergreifen, Gedanken ausführen und entwickeln.';
$string['cercles_de_si_b2_10'] = 'Ich kann wirksam und flüssig ein Interview durchführen, von vorbereiteten Fragen spontan abweichen, auf interessante Antworten näher eingehen und nachfragen.';
$string['cercles_de_si_c1_1'] = 'Ich kann mich spontan, fließend und korrekt über vielfältige alltags-, studien- und berufsbezogene Themen ausdrücken.';
$string['cercles_de_si_c1_2'] = 'Ich kann die Sprache wirksam und flexibel für gesellschaftliche Zwecke gebrauchen, auch für den Ausdruck von Emotionen und Anspielungen oder zum Scherzen.';
$string['cercles_de_si_c1_3'] = 'Ich kann mich effektiv an ausführlichen Diskussionen zu abstrakten und komplexen Themen meines Studien- oder Berufsfelds beteiligen.';
$string['cercles_de_si_c1_4'] = 'Ich kann komplexen Gruppendiskussionen problemlos folgen und auch zu ihnen beitragen, selbst wenn es um abstrakte oder wenig vertraute Themen geht.';
$string['cercles_de_si_c1_5'] = 'Ich kann überzeugend eine formelle Position vertreten, Fragen und Kommentare beantworten, sowie auf komplexe Gegenargumente flüssig, spontan und angemessen reagieren.';
$string['cercles_de_si_c1_6'] = 'Ich kann uneingeschränkt an einem Interview teilnehmen, sowohl als Interviewer/in als auch als Interviewte/r, kann die diskutierte Frage flüssig und ohne fremde Hilfe ausführen und entwickeln, kann gut mit Einwürfen umgehen.';
$string['cercles_de_si_c2_1'] = 'Ich kann alle muttersprachlichen Gesprächspartner verstehen, sofern ich Gelegenheit habe, mich auf einen ungewohnten Akzent oder Dialekt einzustellen.';
$string['cercles_de_si_c2_2'] = 'Ich kann mich sicher und angemessen unterhalten und bin in meinem sozialen und persönlichen Leben in keiner Weise durch sprachliche Einschränkungen beeinträchtigt.';
$string['cercles_de_si_c2_3'] = 'Ich kann mich in formellen Diskussionen komplexer Themen meines Fachgebietes behaupten, indem ich klar und überzeugend argumentiere, ohne gegenüber Muttersprachlern im Nachteil zu sein.';
$string['cercles_de_si_c2_4'] = 'Ich kann meine Dialogrolle in Interviews mit Leichtigkeit ausführen, strukturiere die Redebeiträge, interagiere überzeugend und vollkommen flüssig als Interviewer/in oder Interviewte/r, ohne gegenüber Muttersprachlern im Nachteil zu sein.';

/*
 * descriptors CercleS English
 */
 
$string['cercles_en_li_a1_1'] = 'I can understand basic words and phrases about myself and my family when people speak slowly and clearly ';
$string['cercles_en_li_a1_2'] = 'I can understand simple instructions, directions and comments ';
$string['cercles_en_li_a1_3'] = 'I can understand the names of everyday objects in my immediate environment ';
$string['cercles_en_li_a1_4'] = 'I can understand basic greetings and routine phrases (e.g., please, thank you) ';
$string['cercles_en_li_a1_5'] = 'I can understand simple questions about myself when people speak slowly and clearly ';
$string['cercles_en_li_a1_6'] = 'I can understand numbers and prices ';
$string['cercles_en_li_a1_7'] = 'I can understand days of the week and months of the year ';
$string['cercles_en_li_a1_8'] = 'I can understand times and dates';
$string['cercles_en_li_a2_1'] = 'I can understand what people say to me in simple everyday conversation when they speak slowly and clearly ';
$string['cercles_en_li_a2_2'] = 'I can understand everyday words and phrases relating to areas of immediate personal relevance (e.g., family, student life, local environment, employment) ';
$string['cercles_en_li_a2_3'] = 'I can understand everyday words and phrases relating to areas of personal interest (e.g., hobbies, social life, holidays, music, TV, films, travel) ';
$string['cercles_en_li_a2_4'] = 'I can grasp the essential elements of clear simple messages and recorded announcements (e.g., on the telephone, at the railway station) ';
$string['cercles_en_li_a2_5'] = 'I can understand simple phrases, questions and information relating to basic personal needs (e.g., shopping, eating out, going to the doctor) ';
$string['cercles_en_li_a2_6'] = 'I can follow simple directions (e.g., how to get from X to Y) by foot or public transport ';
$string['cercles_en_li_a2_7'] = 'I can usually identify the topic of conversation around me when people speak slowly and clearly ';
$string['cercles_en_li_a2_8'] = 'I can follow changes of topic in factual TV news items and form an idea of the main content ';
$string['cercles_en_li_a2_9'] = 'I can identify the main point of TV news items reporting events, accidents, etc., if there is visual support';
$string['cercles_en_li_b1_1'] = 'I can follow the gist of everyday conversation when people speak clearly to me in standard dialect ';
$string['cercles_en_li_b1_2'] = 'I can understand straightforward factual information about everyday, study- or work-related topics, identifying both general messages and specific details, provided speech is clearly articulated in a generally familiar accent. ';
$string['cercles_en_li_b1_3'] = 'I can understand the main points of discussions on familiar topics in everyday situations when people speak clearly in standard dialect ';
$string['cercles_en_li_b1_4'] = 'I can follow a lecture or talk within my own academic or professional field, provided the subject matter is familiar and the presentation straightforward and clearly structured ';
$string['cercles_en_li_b1_5'] = 'I can catch the main elements of radio news bulletins and recorded audio material on familiar topics delivered in clear standard speech ';
$string['cercles_en_li_b1_6'] = 'I can follow many TV programmes on topics of personal or cultural interest broadcast in standard dialect ';
$string['cercles_en_li_b1_7'] = 'I can follow many films in which visuals and action carry much of the storyline, when the language is clear and straightforward ';
$string['cercles_en_li_b1_8'] = 'I can follow detailed directions, messages and information (e.g., travel arrangements, recorded weather forecasts, answering-machines) ';
$string['cercles_en_li_b1_9'] = 'I can understand simple technical information, such as operating instructions for everyday equipment';
$string['cercles_en_li_b2_1'] = 'I can understand standard spoken language on both familiar and unfamiliar topics in everyday situations even in a noisy environment ';
$string['cercles_en_li_b2_2'] = 'I can with some effort catch much of what is said around me, but may find it difficult to understand a discussion between several native speakers who do not modify their language in any way ';
$string['cercles_en_li_b2_3'] = 'I can understand announcements and messages on concrete and abstract topics spoken in standard dialect at normal speed ';
$string['cercles_en_li_b2_4'] = 'I can follow extended talks delivered in standard dialect on cultural, intercultural and social issues (e.g., customs, media, lifestyle, EU) ';
$string['cercles_en_li_b2_5'] = 'I can follow complex lines of argument, provided these are clearly signposted and the topic is reasonably familiar ';
$string['cercles_en_li_b2_6'] = 'I can follow the essentials of lectures, talks and reports and other forms of academic or professional presentation in my field ';
$string['cercles_en_li_b2_7'] = 'I can follow most TV news programmes, documentaries, interviews, talk shows and the majority of films in standard dialect ';
$string['cercles_en_li_b2_8'] = 'I can follow most radio programmes and audio material delivered in standard dialect and identify the speaker\'s mood, tone, etc. ';
$string['cercles_en_li_b2_9'] = 'I am sensitive to expressions of feeling and attitudes (e.g., critical, ironic, supportive, flippant, disapproving)';
$string['cercles_en_li_c1_1'] = 'I can follow extended speech even when it is not clearly structured and when relationships are only implied and not signalled explicitly ';
$string['cercles_en_li_c1_2'] = 'I can recognize a wide range of idiomatic expressions and colloquialisms, appreciating register shifts ';
$string['cercles_en_li_c1_3'] = 'I can understand enough to follow extended speech on abstract and complex topics of academic or vocational relevance, though I may need to confirm occasional details, especially if the accent is unfamiliar ';
$string['cercles_en_li_c1_4'] = 'I can easily follow complex interactions between third parties in group discussion and debate, even on abstract and unfamiliar topics ';
$string['cercles_en_li_c1_5'] = 'I can follow most lectures, discussions and debates in my academic or professional field with relative ease ';
$string['cercles_en_li_c1_6'] = 'I can understand complex technical information, such as operating instructions and specifications for familiar products and services ';
$string['cercles_en_li_c1_7'] = 'I can extract specific information from poor quality, audibly distorted public announcements (e.g., in a station, sports stadium, etc.) ';
$string['cercles_en_li_c1_8'] = 'I can understand a wide range of recorded and broadcast audio material, including some non-standard usage, and identify finer points of detail including implicit attitudes and relationships between speakers ';
$string['cercles_en_li_c1_9'] = 'I can follow films employing a considerable degree of slang and idiomatic usage';
$string['cercles_en_li_c2_1'] = 'I have no difficulty in understanding any kind of spoken language, whether live or broadcast, delivered at fast native speed ';
$string['cercles_en_li_c2_2'] = 'I can follow specialised lectures and presentations employing a high degree of colloquialism, regional usage or unfamiliar terminology';
$string['cercles_en_re_a1_1'] = 'I can pick out familiar names, words and phrases in very short simple texts ';
$string['cercles_en_re_a1_2'] = 'I can understand words and phrases on simple everyday signs and notices (e.g., exit, no smoking, danger, days of the week, times) ';
$string['cercles_en_re_a1_3'] = 'I can understand simple forms well enough to give basic personal details (e.g., name, address, date of birth) ';
$string['cercles_en_re_a1_4'] = 'I can understand simple written messages and comments relating to my studies (e.g., "well done", "revise ';
$string['cercles_en_re_a1_5'] = 'I can understand short simple messages on greeting cards and postcards (e.g., holiday greetings, birthday greetings) ';
$string['cercles_en_re_a1_6'] = 'I can get an idea of the content of simple informational material if there is pictorial support (e.g., posters, catalogues, advertisements) ';
$string['cercles_en_re_a1_7'] = 'I can follow short simple written directions (e.g., to go from X to Y)';
$string['cercles_en_re_a2_1'] = 'I can understand short simple messages and texts containing basic everyday vocabulary relating to areas of personal relevance or interest ';
$string['cercles_en_re_a2_2'] = 'I can understand everyday signs and public notices (e.g., on the street, in shops, hotels, railway stations) ';
$string['cercles_en_re_a2_3'] = 'I can find specific predictable information in simple everyday material such as advertisements, timetables, menus, directories, brochures ';
$string['cercles_en_re_a2_4'] = 'I can understand instructions when expressed in simple language (e.g., how to use a public telephone) ';
$string['cercles_en_re_a2_5'] = 'I can understand regulations when expressed in simple language (e.g., safety, attendance at lectures) ';
$string['cercles_en_re_a2_6'] = 'I can understand short simple personal letters giving or requesting information about everyday life or offering an invitation ';
$string['cercles_en_re_a2_7'] = 'I can identify key information in short newspaper/magazine reports recounting stories or events ';
$string['cercles_en_re_a2_8'] = 'I can understand basic information in routine letters and messages (e.g., hotel reservations, personal telephone messages)';
$string['cercles_en_re_b1_1'] = 'I can read straightforward factual texts on subjects related to my field of interest with a reasonable level of understanding ';
$string['cercles_en_re_b1_2'] = 'I can recognize significant points in straightforward newspaper articles on familiar subjects ';
$string['cercles_en_re_b1_3'] = 'I can identify the main conclusions in clearly signaled argumentative texts related to my academic or professional field ';
$string['cercles_en_re_b1_4'] = 'I can understand the description of events, feelings and wishes in personal letters and e¬mails well enough to correspond with a pen friend ';
$string['cercles_en_re_b1_5'] = 'I can find and understand relevant information in everyday material, such as standard letters, brochures and short official documents ';
$string['cercles_en_re_b1_6'] = 'I can understand clearly written straightforward instructions (e.g., for using a piece of equipment, for answering questions in an exam) ';
$string['cercles_en_re_b1_7'] = 'I can scan longer texts in order to locate desired information, and gather information from different parts of a text, or from different texts in order to fulfill a specific task ';
$string['cercles_en_re_b1_8'] = 'I can follow the plot of clearly structured narratives and modern literary texts';
$string['cercles_en_re_b2_1'] = 'I can quickly scan through long and complex texts on a variety of topics in my field to locate relevant details ';
$string['cercles_en_re_b2_2'] = 'I can read correspondence relating to my field of interest and readily grasp the essential meaning ';
$string['cercles_en_re_b2_3'] = 'I can obtain information, ideas and opinions from highly specialized sources within my academic or professional field ';
$string['cercles_en_re_b2_4'] = 'I can understand articles on specialized topics using a dictionary and other appropriate reference resources ';
$string['cercles_en_re_b2_5'] = 'I can quickly identify the content and relevance of news items, articles and reports on a wide range of professional topics, deciding whether closer study is worthwhile ';
$string['cercles_en_re_b2_6'] = 'I can understand articles and reports concerned with contemporary problems in which the writers adopt particular stances or viewpoints ';
$string['cercles_en_re_b2_7'] = 'I can understand lengthy complex instructions in my field, including details on conditions or warnings, provided I can reread difficult sections ';
$string['cercles_en_re_b2_8'] = 'I can readily appreciate most narratives and modern literary texts (e.g., novels, short stories, poems, plays)';
$string['cercles_en_re_c1_1'] = 'I can understand in detail highly specialized texts in my own academic or professional field, such as research reports and abstracts ';
$string['cercles_en_re_c1_2'] = 'I can understand any correspondence given the occasional use of a dictionary ';
$string['cercles_en_re_c1_3'] = 'I can read contemporary literary texts with no difficulty and with appreciation of implicit meanings and ideas ';
$string['cercles_en_re_c1_4'] = 'I can appreciate the relevant socio-historical or political context of most literary works ';
$string['cercles_en_re_c1_5'] = 'I can understand detailed and complex instructions for a new machine or procedure, whether or not the instructions relate to my own area of speciality, provided I can reread difficult sections';
$string['cercles_en_re_c2_1'] = 'I can understand a wide range of long and complex texts, appreciating subtle distinctions of style and implicit as well as explicit meaning ';
$string['cercles_en_re_c2_2'] = 'I can understand and interpret critically virtually all forms of the written language including abstract, structurally complex, or highly colloquial literary and non-literary writings ';
$string['cercles_en_re_c2_3'] = 'I can make effective use of complex, technical or highly specialized texts to meet my academic or professional purposes ';
$string['cercles_en_re_c2_4'] = 'I can critically appraise classical as well as contemporary literary texts in different genres ';
$string['cercles_en_re_c2_5'] = 'I can appreciate the finer subtleties of meaning, rhetorical effect and stylistic language use in critical or satirical forms of discourse ';
$string['cercles_en_re_c2_6'] = 'I can understand complex factual documents such as technical manuals and legal contracts';
$string['cercles_en_wr_a1_1'] = 'I can fill in a simple form or questionnaire with my personal details (e.g., date of birth, address, nationality) ';
$string['cercles_en_wr_a1_2'] = 'I can write a greeting card or simple postcard ';
$string['cercles_en_wr_a1_3'] = 'I can write simple phrases and sentences about myself (e.g., where I live, how many brothers and sisters I have) ';
$string['cercles_en_wr_a1_4'] = 'I can write a short simple note or message (e.g., to tell somebody where I am or where to meet)';
$string['cercles_en_wr_a2_1'] = 'I can write short simple notes and messages (e.g., saying that someone telephoned, arranging to meet someone, explaining absence) ';
$string['cercles_en_wr_a2_2'] = 'I can fill in a questionnaire or write a simple curriculum vitae giving personal information ';
$string['cercles_en_wr_a2_3'] = 'I can write about aspects of my everyday life in simple linked sentences (e.g., family, college life, holidays, work experience) ';
$string['cercles_en_wr_a2_4'] = 'I can write short simple imaginary biographies and stories about people ';
$string['cercles_en_wr_a2_5'] = 'I can write very short basic descriptions of events, past activities and personal experiences ';
$string['cercles_en_wr_a2_6'] = 'I can open and close a simple personal letter using appropriate phrases and greetings ';
$string['cercles_en_wr_a2_7'] = 'I can write a very simple personal letter (e.g., accepting or offering an invitation, thanking someone for something, apologizing) ';
$string['cercles_en_wr_a2_8'] = 'I can open and close a simple formal letter using appropriate phrases and greetings ';
$string['cercles_en_wr_a2_9'] = 'I can write very basic formal letters requesting information (e.g., about summer jobs, hotel accommodation)';
$string['cercles_en_wr_b1_1'] = 'I can write a description of an event (e.g., a recent trip), real or imagined ';
$string['cercles_en_wr_b1_2'] = 'I can write notes conveying simple information of immediate relevance to people who feature in my everyday life, getting across comprehensibly the points I feel are important ';
$string['cercles_en_wr_b1_3'] = 'I can write personal letters giving news, describing experiences and impressions, and expressing feelings ';
$string['cercles_en_wr_b1_4'] = 'I can take down messages communicating enquiries and factual information, explaining problems ';
$string['cercles_en_wr_b1_5'] = 'I can write straightforward connected texts and simple essays on familiar subjects within my field, by linking a series of shorter discrete elements into a linear sequence, and using dictionaries and reference resources ';
$string['cercles_en_wr_b1_6'] = 'I can describe the plot of a film or book, or narrate a simple story ';
$string['cercles_en_wr_b1_7'] = 'I can write very brief reports to a standard conventionalized format, which pass on routine factual information on matters relating to my field ';
$string['cercles_en_wr_b1_8'] = 'I can summarize, report and give my opinion about accumulated factual information on familiar matters in my field with some confidence ';
$string['cercles_en_wr_b1_9'] = 'I can write standard letters giving or requesting detailed information (e.g., replying to an advertisement, applying for a job)';
$string['cercles_en_wr_b2_1'] = 'I can write clear detailed text on a wide range of subjects relating to my personal, academic or professional interests ';
$string['cercles_en_wr_b2_2'] = 'I can write letters conveying degrees of emotion and highlighting the personal significance of events and experiences, and commenting on the correspondents news and views ';
$string['cercles_en_wr_b2_3'] = 'I can express news, views and feelings effectively in writing, and relate to those of others ';
$string['cercles_en_wr_b2_4'] = 'I can write summaries of articles on topics of general, academic or professional interest, and summarize information from different sources and media ';
$string['cercles_en_wr_b2_5'] = 'I can write an essay or report which develops an argument, giving reasons to support or negate a point of view, weighing pros and cons ';
$string['cercles_en_wr_b2_6'] = 'I can summarize and synthesize information and arguments from a number of sources ';
$string['cercles_en_wr_b2_7'] = 'I can write a short review of a film or book ';
$string['cercles_en_wr_b2_8'] = 'I can write clear detailed descriptions of real or imaginary events and experiences in a detailed and easily readable way, marking the relationship between ideas ';
$string['cercles_en_wr_b2_9'] = 'I can write standard formal letters requesting or communicating relevant information, with appropriate use of register and conventions';
$string['cercles_en_wr_c1_1'] = 'I can express myself fluently and accurately in writing on a wide range of personal, academic or professional topics, varying my vocabulary and style according to the context ';
$string['cercles_en_wr_c1_2'] = 'I can express myself with clarity and precision in personal correspondence, using language flexibly and effectively, including emotional, allusive and joking usage ';
$string['cercles_en_wr_c1_3'] = 'I can write clear, well-structured texts on complex subjects in my field, underlining the relevant salient issues, expanding and supporting points of view at some length with subsidiary points, reasons and relevant examples, and rounding off with an appropriate conclusion ';
$string['cercles_en_wr_c1_4'] = 'I can write clear, detailed, well-structured and developed descriptions and imaginative texts in an assured, personal, natural style appropriate to the reader in mind ';
$string['cercles_en_wr_c1_5'] = 'I can elaborate my case effectively and accurately in complex formal letters (e.g., registering a complaint, taking a stand against an issue)';
$string['cercles_en_wr_c2_1'] = 'I can write clear, smoothly-flowing, complex texts relating to my academic or professional work in an appropriate and effective style and a logical structure which helps the reader to find significant points ';
$string['cercles_en_wr_c2_2'] = 'I can write clear, smoothly-flowing, and fully engrossing stories and descriptions of experience in a style appropriate to the genre adopted ';
$string['cercles_en_wr_c2_3'] = 'I can write a well-structured critical review of a paper, project or proposal relating to my academic or professional field, giving reasons for my opinion ';
$string['cercles_en_wr_c2_4'] = 'I can produce clear, smoothly-flowing, complex reports, articles or essays which present a case or elaborate an argument ';
$string['cercles_en_wr_c2_5'] = 'I can provide an appropriate and effective logical structure which helps the reader to find significant points ';
$string['cercles_en_wr_c2_6'] = 'I can write detailed critical appraisals of cultural events or literary works ';
$string['cercles_en_wr_c2_7'] = 'I can write persuasive and well-structured complex formal letters in an appropriate style';
$string['cercles_en_sp_a1_1'] = 'I can give basic personal information about myself (e.g., age, address, family, subjects of study) ';
$string['cercles_en_sp_a1_2'] = 'I can use simple words and phrases to describe where I live ';
$string['cercles_en_sp_a1_3'] = 'I can use simple words and phrases to describe people I know ';
$string['cercles_en_sp_a1_4'] = 'I can read a very short rehearsed statement (e.g., to introduce a speaker, propose a toast)';
$string['cercles_en_sp_a2_1'] = 'I can describe myself, my family and other people I know ';
$string['cercles_en_sp_a2_2'] = 'I can describe my home and where I live ';
$string['cercles_en_sp_a2_3'] = 'I can say what I usually do at home, at university, in my free time ';
$string['cercles_en_sp_a2_4'] = 'I can describe my educational background and subjects of study ';
$string['cercles_en_sp_a2_5'] = 'I can describe plans, arrangements and alternatives ';
$string['cercles_en_sp_a2_6'] = 'I can give short simple descriptions of events or tell a simple story ';
$string['cercles_en_sp_a2_7'] = 'I can describe past activities and personal experiences (e.g., what I did at the weekend) ';
$string['cercles_en_sp_a2_8'] = 'I can explain what I like and don\'t like about something ';
$string['cercles_en_sp_a2_9'] = 'I can give simple descriptions of things and make comparisons ';
$string['cercles_en_sp_a2_10'] = 'I can deliver very short rehearsed announcements of predictable learnt content ';
$string['cercles_en_sp_a2_11'] = 'I can give a short rehearsed presentation on a familiar subject in my academic or professional field';
$string['cercles_en_sp_b1_1'] = 'I can give a reasonably fluent description of a subject within my academic or professional field, presenting it as a linear sequence of points ';
$string['cercles_en_sp_b1_2'] = 'I can narrate a story or relate the plot of a film or book ';
$string['cercles_en_sp_b1_3'] = 'I can describe personal experiences, reactions, dreams, hopes, ambitions, real, Imagined or unexpected events ';
$string['cercles_en_sp_b1_4'] = 'I can briefly give reasons and explanations for opinions, plans and actions ';
$string['cercles_en_sp_b1_5'] = 'I can develop an argument well enough to be followed without difficulty most of the time ';
$string['cercles_en_sp_b1_6'] = 'I can give a simple summary of short written texts ';
$string['cercles_en_sp_b1_7'] = 'I can give detailed accounts of problems and incidents (e.g., reporting a theft, traffic accident) ';
$string['cercles_en_sp_b1_8'] = 'I can deliver short rehearsed announcements and statements on everyday matters within my field ';
$string['cercles_en_sp_b1_9'] = 'I can give a short and straightforward prepared presentation on a chosen topic in my academic or professional field in a reasonably clear and precise manner';
$string['cercles_en_sp_b2_1'] = 'I can give clear detailed descriptions on a wide range of subjects relating to my field, expanding and supporting ideas with subsidiary points and relevant examples ';
$string['cercles_en_sp_b2_2'] = 'I can explain a viewpoint on a topical issue, giving the advantages and disadvantages of various options ';
$string['cercles_en_sp_b2_3'] = 'I can develop a clear coherent argument, linking ideas logically and expanding and supporting my points with appropriate examples ';
$string['cercles_en_sp_b2_4'] = 'I can outline an issue or a problem clearly, speculating about causes, consequences and hypothetical situations ';
$string['cercles_en_sp_b2_5'] = 'I can summarize short discursive or narrative material (e.g., written, radio, television) ';
$string['cercles_en_sp_b2_6'] = 'I can deliver announcements on most general topics with a degree of clarity, fluency and spontaneity which causes no strain or inconvenience to the listener ';
$string['cercles_en_sp_b2_7'] = 'I can give a clear, systematically developed presentation on a topic in my field, with highlighting of significant points and relevant supporting detail ';
$string['cercles_en_sp_b2_8'] = 'I can depart spontaneously from a prepared text and follow up points raised by an audience';
$string['cercles_en_sp_c1_1'] = 'I can give clear detailed descriptions of complex subjects in my field ';
$string['cercles_en_sp_c1_2'] = 'I can elaborate a detailed argument or narrative, integrating sub-themes, developing particular points and rounding off with an appropriate conclusion ';
$string['cercles_en_sp_c1_3'] = 'I can give a detailed oral summary of long and complex texts relating to my area of study ';
$string['cercles_en_sp_c1_4'] = 'I can deliver announcements fluently, almost effortlessly, using stress and intonation to convey finer shades of meaning precisely ';
$string['cercles_en_sp_c1_5'] = 'I can give a clear, well-structured presentation on a complex subject in my field, expanding and supporting points of view with appropriate reasons and examples';
$string['cercles_en_sp_c2_1'] = 'I can produce clear, smoothly-flowing well-structured speech with an effective logical structure which helps the recipient to notice and remember significant points ';
$string['cercles_en_sp_c2_2'] = 'I can give clear, fluent, elaborate and often memorable descriptions ';
$string['cercles_en_sp_c2_3'] = 'I can summarize and synthesize information and ideas from a variety of specialized sources in my field in a clear and flexible manner ';
$string['cercles_en_sp_c2_4'] = 'I can present a complex topic in my field confidently and articulately, and can handle difficult and even hostile questioning';
$string['cercles_en_si_a1_1'] = 'I can say basic greetings and phrases (e.g., please, thank you), ask how someone is and say how I am ';
$string['cercles_en_si_a1_2'] = 'I can say who I am, ask someone\'s name and introduce someone ';
$string['cercles_en_si_a1_3'] = 'I can say I don\'t understand, ask people to repeat what they say or speak more slowly, attract attention and ask for help ';
$string['cercles_en_si_a1_4'] = 'I can ask how to say something in the language or what a word means ';
$string['cercles_en_si_a1_5'] = 'I can ask and answer simple direct questions on very familiar topics (e.g., family, student life) with help from the person I am talking to ';
$string['cercles_en_si_a1_6'] = 'I can ask people for things and give people things ';
$string['cercles_en_si_a1_7'] = 'I can handle numbers, quantities, cost and time ';
$string['cercles_en_si_a1_8'] = 'I can make simple purchases, using pointing and gestures to support what I say ';
$string['cercles_en_si_a1_9'] = 'I can reply in an interview to simple direct questions about personal details if these are spoken very slowly and clearly in standard dialect';
$string['cercles_en_si_a2_1'] = 'I can handle short social exchanges and make myself understood if people help me ';
$string['cercles_en_si_a2_2'] = 'I can participate in short conversations in routine contexts on topics of interest ';
$string['cercles_en_si_a2_3'] = 'I can make and respond to Invitations, suggestions, apologies and requests for permission ';
$string['cercles_en_si_a2_4'] = 'I can say what I like or dislike, agree or disagree with people, and make comparisons ';
$string['cercles_en_si_a2_5'] = 'I can express what I feel in simple terms, and express thanks ';
$string['cercles_en_si_a2_6'] = 'I can discuss what to do, where to go, make arrangements to meet (e.g., in the evening, at the weekend) ';
$string['cercles_en_si_a2_7'] = 'I can ask and answer simple questions about familiar topics (e.g., weather, hobbies, social life, music, sport) ';
$string['cercles_en_si_a2_8'] = 'I can ask and answer simple questions about things that have happened (e.g., yesterday, last week, last year) ';
$string['cercles_en_si_a2_9'] = 'I can handle simple telephone calls (e.g., say who is calling, ask to speak to someone, give my number, take a simple message) ';
$string['cercles_en_si_a2_10'] = 'I can make simple transactions (e.g., in shops, post offices, railway stations) and order something to eat or drink ';
$string['cercles_en_si_a2_11'] = 'I can get simple practical information (e.g., asking for directions, booking accommodation, going to the doctor)';
$string['cercles_en_si_b1_1'] = 'I can readily handle conversations on most topics that are familiar or of personal interest, with generally appropriate use of register ';
$string['cercles_en_si_b1_2'] = 'I can sustain an extended conversation or discussion but may sometimes need a little help in communicating my thoughts ';
$string['cercles_en_si_b1_3'] = 'I can take part in routine formal discussion on familiar subjects in my academic or professional field if it is conducted in clearly articulated speech in standard dialect ';
$string['cercles_en_si_b1_4'] = 'I can exchange, check and confirm factual information on familiar routine and non-routine matters within my field with some confidence ';
$string['cercles_en_si_b1_5'] = 'I can express and respond to feelings and attitudes (e.g., surprise, happiness, sadness, interest, uncertainty, indifference) ';
$string['cercles_en_si_b1_6'] = 'I can agree and disagree politely, exchange personal opinions, negotiate decisions and ideas ';
$string['cercles_en_si_b1_7'] = 'I can express my thoughts about abstract or cultural topics such as music or films, and give brief comments on the views of others ';
$string['cercles_en_si_b1_8'] = 'I can explain why something is a problem, discuss what to do next, compare and contrast alternatives ';
$string['cercles_en_si_b1_9'] = 'I can obtain detailed information, messages, instructions and explanations, and can ask for and follow detailed directions ';
$string['cercles_en_si_b1_10'] = 'I can handle most practical tasks in everyday situations (e.g., making telephone enquiries, asking for a refund, negotiating purchase) ';
$string['cercles_en_si_b1_11'] = 'I can provide concrete information required in an interview/consultation (e.g., describe symptoms to a doctor), but with limited precision ';
$string['cercles_en_si_b1_12'] = 'I can take some initiatives in an interview/consultation (e.g., bring up a new subject) but am very dependent on the interviewer to provide support ';
$string['cercles_en_si_b1_13'] = 'I can use a prepared questionnaire to carry out a structured interview, with some spontaneous follow-up questions';
$string['cercles_en_si_b2_1'] = 'I can participate fully in conversations on general topics with a degree of fluency and naturalness, and appropriate use of register ';
$string['cercles_en_si_b2_2'] = 'I can participate effectively in extended discussions and debates on subjects of personal, academic or professional interest, marking clearly the relationship between ideas ';
$string['cercles_en_si_b2_3'] = 'I can account for and sustain my opinion in discussion by providing relevant explanations, arguments and comments ';
$string['cercles_en_si_b2_4'] = 'I can express, negotiate and respond sensitively to feelings, attitudes, opinions, tone, viewpoints ';
$string['cercles_en_si_b2_5'] = 'I can exchange detailed factual information on matters within my academic or professional field ';
$string['cercles_en_si_b2_6'] = 'I can help along the progress of a project by inviting others to join in, express their opinions, etc. ';
$string['cercles_en_si_b2_7'] = 'I can cope linguistically with potentially complex problems in routine situations (e.g., complaining about goods and services) ';
$string['cercles_en_si_b2_8'] = 'I can cope adequately with emergencies (e.g., summon medical assistance, telephone the police or breakdown service) ';
$string['cercles_en_si_b2_9'] = 'I can handle personal interviews with ease, taking initiatives and expanding ideas with little help or prodding from an interviewer ';
$string['cercles_en_si_b2_10'] = 'I can carry out an effective, fluent interview, departing spontaneously from prepared questions, following up and probing interesting replies';
$string['cercles_en_si_c1_1'] = 'I can express myself fluently, accurately and spontaneously on a wide range of general, academic or professional topics ';
$string['cercles_en_si_c1_2'] = 'I can use language flexibly and effectively for social purposes, including emotional, allusive and joking usage ';
$string['cercles_en_si_c1_3'] = 'I can participate effectively in extended debates on abstract and complex topics of a specialist nature in my academic or professional field ';
$string['cercles_en_si_c1_4'] = 'I can easily follow and contribute to complex interactions between third parties in group discussion even on abstract or less familiar topics ';
$string['cercles_en_si_c1_5'] = 'I can argue a formal position convincingly, responding to questions and comments and answering complex lines of counter argument fluently, spontaneously and appropriately ';
$string['cercles_en_si_c1_6'] = 'I can participate fully in an interview, as either interviewer or interviewee, fluently expanding and developing the point under discussion, and handling interjections well';
$string['cercles_en_si_c2_1'] = 'I can understand any native speaker interlocutor, given an opportunity to adjust to a non¬standard accent or dialect ';
$string['cercles_en_si_c2_2'] = 'I can converse comfortably and appropriately, unhampered by any linguistic limitations in conducting a full social and personal life ';
$string['cercles_en_si_c2_3'] = 'I can hold my own in formal discussion of complex and specialist issues in my field, putting forward and sustaining an articulate and persuasive argument, at no disadvantage to native speakers ';
$string['cercles_en_si_c2_4'] = 'I can keep up my side of the dialogue as interviewer or interviewee with complete confidence and fluency, structuring the talk and interacting authoritatively at no disadvantage to a native speaker';

/*
 * descriptors Schule German
 */
 
$string['schule_de_li_a1_1'] = 'Ich kann verstehen, wenn andere mir Fragen zu meiner Person stellen.';
$string['schule_de_li_a1_2'] = 'Ich kann verstehen, wenn andere sich selbst vorstellen.';
$string['schule_de_li_a1_3'] = 'Ich kann Fragen und Informationen zum Tages- und Jahresablauf verstehen.';
$string['schule_de_li_a1_4'] = 'Ich kann verstehen, wenn ich im Unterricht angesprochen werde.';
$string['schule_de_li_a1_5'] = 'Ich kann Arbeitsanweisungen verstehen.';
$string['schule_de_li_a1_6'] = 'Ich kann verstehen, wenn jemand sagt, wo sich etwas befindet und wie weit es entfernt ist.';
$string['schule_de_li_a1_7'] = 'Ich kann verstehen, wenn jemand sagt, wie ich an einen bestimmten Ort komme.';
$string['schule_de_li_a1_8'] = 'Ich kann verstehen, wenn jemand sagt, wie teuer etwas ist.';
$string['schule_de_li_a1_9'] = 'Ich kann einzelne Wörter und Sätze wiedererkennen, wenn andere Leute miteinander sprechen.';
$string['schule_de_li_a1_10'] = 'Ich kann verstehen, worum es geht, wenn ich einfache Texte und Geschichten - auch von einer CD - höre.';
$string['schule_de_li_a2_1'] = 'Ich kann verstehen, wenn jemand mit mir über Dinge spricht, die mich betreffen (z.B. Schule, Hobbys, Freizeit, Familie).';
$string['schule_de_li_a2_2'] = 'Ich kann Gesprächen folgen, wenn sie mit mir, meiner Familie und Dingen zu tun haben, die mich interessieren.';
$string['schule_de_li_a2_3'] = 'Ich kann genug verstehen, um mich im Alltag (z.B. in einem Geschäft, auf der Post) zurecht zu finden.';
$string['schule_de_li_a2_4'] = 'Ich kann das Wesentliche bei kurzen, deutlichen Mitteilungen, Anweisungen und Durchsagen verstehen.';
$string['schule_de_li_a2_5'] = 'Ich kann Texten aus Kassette, CD oder DVD folgen, wenn es um Dinge geht, die ich kenne.';
$string['schule_de_li_a2_6'] = 'Ich kann auch Einzelheiten verstehen, wenn ich die Texte mehrmals hören kann.';
$string['schule_de_li_a2_7'] = 'Ich kann einfache Geschichten, Lieder und Gedichte im Großen und Ganzen verstehen.';
$string['schule_de_li_b1_1'] = 'Ich kann in längeren Alltagsgesprächen den Hauptaussagen folgen.';
$string['schule_de_li_b1_2'] = 'Ich kann Erzählungen aus dem Alltag verstehen.';
$string['schule_de_li_b1_3'] = 'Ich kann Anweisungen, Aufforderungen, Auskünfte ohne größere Mühe verstehen und darauf reagieren.';
$string['schule_de_li_b1_4'] = 'Ich kann Beschreibungen Berichten die wichtigsten Informationen entnehmen.';
$string['schule_de_li_b1_5'] = 'Ich kann längeren gesprochenen Texten gezielt Einzelinformationen entnehmen.';
$string['schule_de_li_b1_6'] = 'Ich kann in Radionachrichten oder Tonaufnahmen über vertraute Themen die Hauptpunkte verstehen.';
$string['schule_de_li_b1_7'] = 'Ich kann in Fernsehsendungen, kurzen Filmen und Clips die Hauptpunkte erfassen, wenn mir die Themen vertraut sind.';
$string['schule_de_li_b1_8'] = 'Ich kann den Sinn von Geschichten, Liedern und Gedichten verstehen.';
$string['schule_de_li_b2_1'] = 'Ich kann Geprächen, auch zwischen Muttersprachlern, folgen, wenn sie miteinander Standardsprache sprechen und ich übert den Gesprächsgegenstand einigermaßen Bescheid weiß.';
$string['schule_de_li_b2_2'] = 'Ich kann unerwartete Ankündigungen und Durchsagen verstehen, wenn die Ansage deutlich und störungsfrei ist.';
$string['schule_de_li_b2_3'] = 'Ich kann mein Gegenüber am Telefon gut verstehen, wenn Alltägliches besprochen wird oder Themen, die mir vertraut sind.';
$string['schule_de_li_b2_4'] = 'Ich kann die wichtigsten Aussagen von schwierigeren Redebeiträgen, wie Berichten, Präsentationen und Argumentationen, gut verstehen, wenn Standardsprache gesprochen wird und mir das Thema einigermaßen vertraut ist.';
$string['schule_de_li_b2_5'] = 'Ich kann die meisten aktuellen Nachrichtensendungen und Reportagen im Fernsehen verstehen.';
$string['schule_de_li_b2_6'] = 'Ich kann den meisten Spielfilmen und Theaterstücken folgen, sofern Standardsprache gesprochen wird.';
$string['schule_de_li_b2_7'] = 'Ich kann dem Vortrag von komplexeren Gedichten und Geschichten in Standardsprache folgen.';
$string['schule_de_li_c1_1'] = 'Ich habe kein Problem, gesprochene Sprache von Muttersprachlerinnen und Muttersprachlern zu verstehen, auch bei ungewohnter Aussprache und unbekannten Redewendungen, sofern ich die Gelegenheit habe nachzufragen.';
$string['schule_de_li_c1_2'] = 'Ich kann öffentliche Durchsagen im Allgemeinen verstehen.';
$string['schule_de_li_c1_3'] = 'Ich kann längeren Debatten, Reden und Vorträgen folgen, auch wenn sie nicht klar strukturiert sind und mir die angesprochenen Themen und Inhalte im Vorhinein nicht bekannt sind.';
$string['schule_de_li_c1_4'] = 'Ich kann Radio- und Fernsehsendungen gut folgen und dabei auch komplexere Informationen und Zusammenhänge verstehen.';
$string['schule_de_li_c1_5'] = 'Ich kann künstlerischen Darbietungen (Film, Theater, öffentliche Lesung) im Allgemeinen ohne Mühe folgen.';
$string['schule_de_li_c2_1'] = 'Ich verstehe meine Gesprächspartnerinnen und Gesprächspartner in Alltagsgesprächen, auch am Telefon, mühelos, auch wenn ich mich manchmal erst an einen besonderen Akzent gewöhnen muss.';
$string['schule_de_li_c2_2'] = 'Ich kann komplexe Redebeiträge in Debatten, Reden und Vorträgen zu unterschiedlichen Themen ohne Mühe verstehen, gleich ob ich sie persönlich oder in den Medien höre.';
$string['schule_de_li_c2_3'] = 'Ich kann künstlerische Darbietungen in den Medien (Radio, Fernsehen, Kino, Theater) und live mit Genuss verfolgen.';
$string['schule_de_re_a1_1'] = 'Ich kann herausfinden, worum es auf Plakaten, Prospekten usw. geht.';
$string['schule_de_re_a1_2'] = 'Ich kann Briefe, Postkarten, E-Mails und SMS verstehen.';
$string['schule_de_re_a1_3'] = 'Ich kann Notizen und Mitteilungen verstehen.';
$string['schule_de_re_a1_4'] = 'Ich kann schriftliche Arbeitsaufträge verstehen.';
$string['schule_de_re_a1_5'] = 'Ich kann bei kurzen Geschichten, Reimen, Gedichten usw. verstehen, worum es geht, wenn mir Bilder dabei helfen.';
$string['schule_de_re_a2_1'] = 'Ich kann in Fahrplänen, Katalogen, Programmen, Anzeigen usw. Informationen finden, die ich suche (z.B. Ort, Zeit, Preis).';
$string['schule_de_re_a2_2'] = 'Ich kann persönliche Mitteilungen (SMS, Postkarten, E-Mails, Briefe) und kurze Erlebnisberichte verstehen.';
$string['schule_de_re_a2_3'] = 'Ich kann geschriebenen Anweisungen (z.B. Hilfstexten in Computerprogrammen, Gebrauchsanweisungen, Rezepten) die wichtigsten Informationen entnehmen.';
$string['schule_de_re_a2_4'] = 'Ich kann kurze Texte über allgemeine Themen, wie z.B. das Leben in anderen Ländern, im Wesentlichen verstehen.';
$string['schule_de_re_a2_5'] = 'Ich kann einfachen Geschichten, Gedichten usw. folgen, wenn mir z.B. Schlüsselwörter helfen.';
$string['schule_de_re_b1_1'] = 'Ich kann private Briefe, Karten und E-Mails verstehen, in denen Gefühle, Wünsche und Erlebnisse beschrieben werden.';
$string['schule_de_re_b1_2'] = 'Ich kann einfache Mitteilungen und Standardbriefe verstehen (z.B. von Geschäften, Vereinen oder Behörden).';
$string['schule_de_re_b1_3'] = 'Ich kann einfache Sachtexte zu allgemeinen Themen lesen und ihnen gezielt Informationen entnehmen.';
$string['schule_de_re_b1_4'] = 'Ich kann den Gedanken und Argumenten in einem Text folgen, ohne diesen in allen Einzelheiten zu verstehen.';
$string['schule_de_re_b1_5'] = 'Ich kann den Sinn von Geschichten, Theaterstücken, Gedichten, Liedtexten usw. erfassen.';
$string['schule_de_re_b2_1'] = 'Ich kann private Korrespondenz und Standardbriefe von Behörden und Unternehmen verstehen.';
$string['schule_de_re_b2_2'] = 'Ich kann langen, auch schwierigeren Texten beim raschen Überfliegen die wichtigsten Informationen entnehmen und entscheiden, ob sich genaues Lesen für meine Zwecke lohnt.';
$string['schule_de_re_b2_3'] = 'Ich kann beim Lesen auch umfangreicherer Texte den dargelegten Gedanken folgen und Standpunkte ermitteln.';
$string['schule_de_re_b2_4'] = 'Ich kann zeitgenössische literarische Texte lesen und dabei der Gesamtaussage und bestimmten Aspekten im Einzelnen nachgehen (z.B. Handlungsverlauf, Charakter von Personen, Atmosphäre und Stimmungen).';
$string['schule_de_re_c1_1'] = 'Ich kann unter gelegentlicher Zuhilfenahme eines Wörterbuchs jede Art von Korrespondenz verstehen.';
$string['schule_de_re_c1_2'] = 'Ich kann sprachlich anspruchsvolle längere Texte im Wesentlichen verstehen, wenn ich bei besonders schwierigen Abschnitten Hilfsmittel (Wörterbuch, Suchmaschine usw.) verwende';
$string['schule_de_re_c1_3'] = 'Ich kann längere komplexe Anleitungen und Anweisungen verstehen, z. B. zur Bedienung eines neuen Geräts, auch wenn diese nicht in Bezug zu meinem Sach- oder Interessensgebiet stehen.';
$string['schule_de_re_c1_4'] = 'Ich kann in längeren Analysen, Berichten und Kommentaren Meinungen, Standpunkte und Zusammenhänge erfassen.';
$string['schule_de_re_c1_5'] = 'Ich kann literarische und journalistische Texte gut verstehen und Unterschiede in Stil und Ausdruck wahrnehmen.';
$string['schule_de_re_c2_1'] = 'Ich kann Texte verstehen, die stark von der Standardsprache abweichen.';
$string['schule_de_re_c2_2'] = 'Ich kann Handbücher, Verordnungen und Verträge verstehen, auch wenn mir das Gebiet nicht vertraut ist.';
$string['schule_de_re_c2_3'] = 'Ich kann zeitgenössische und klassische literarische Texte verschiedener Gattungen lesen (Gedichte, Prosa, dramatische Werke).';
$string['schule_de_re_c2_4'] = 'Ich kann Wortspiele erkennen und Texte richtig verstehen, deren eigentliche Bedeutung nicht in dem liegt, was vordergründig gesagt wird (z. B. Ironie, Satire).';
$string['schule_de_wr_a1_1'] = 'Ich kann kurze Texte über mich und andere Personen schreiben.';
$string['schule_de_wr_a1_2'] = 'Ich kann über mein Zuhause, meinen Schulalltag und meine Freizeit schreiben.';
$string['schule_de_wr_a1_3'] = 'Ich kann Notizen und Mitteilungen an Freunde schreiben.';
$string['schule_de_wr_a1_4'] = 'Ich kann Fragen stellen (z.B. in einem Brief oder einer E-Mail) und Fragen schriftlich beantworten.';
$string['schule_de_wr_a2_1'] = 'Ich kann Texte über meine Familie, meine Interessen, die Schule oder Freizeitaktivitäten schreiben.';
$string['schule_de_wr_a2_2'] = 'Ich kann Orte, Gegenstände und Personen aus meiner Umgebung in einem kurzen Text beschreiben.';
$string['schule_de_wr_a2_3'] = 'Ich kann eine kurze Notiz oder Mitteilung schreiben, um jemanden zu informieren, z.B. wo ich bin oder wo wir uns treffen.';
$string['schule_de_wr_a2_4'] = 'Ich kann kurze Briefe, Postkarten, E-Mails oder SMS schreiben, in denen ich mich auch bedanken oder entschuldigen kann.';
$string['schule_de_wr_a2_5'] = 'Ich kann einfache kürzere Texte über Erlebtes, Gelesenes oder Erfundenes schreiben.';
$string['schule_de_wr_b1_1'] = 'Ich kann schriftlich darstellen, was ich getan und erlebt habe und wie ich mich dabei gefühlt habe.';
$string['schule_de_wr_b1_2'] = 'Ich kann meine Meinung, Gefühle und Anteilnahme ausdrücken, z.B. in Briefen und E-Mails.';
$string['schule_de_wr_b1_3'] = 'Ich kann mit Hilfe einer Vorlage einfache formelle Schreiben verfassen, z.B. einen Lebenslauf, ein Bewerbungsschreiben oder einen Geschäftsbrief.';
$string['schule_de_wr_b1_4'] = 'Ich kann gezielt Informationen aus Gehörtem und Gelesenem in Notizen festhalten.';
$string['schule_de_wr_b1_5'] = 'Ich kann einfache Sachinformationen schriftlich mitteilen oder danach fragen.';
$string['schule_de_wr_b1_6'] = 'Ich kann den Handlungsverlauf von gelesenen oder gehörten Texten schriftlich wiedergeben.';
$string['schule_de_wr_b1_7'] = 'Ich kann über verschiedene Themen einen Text schreiben und darin persönliche Ansichten und Meinungen, Gefühle und Stimmungen ausdrücken.';
$string['schule_de_wr_b2_1'] = 'Ich kann gegliedert und anschaulich beschreiben, was ich erlebt, erfahren oder mir ausgedacht habe.';
$string['schule_de_wr_b2_2'] = 'Ich kann private Briefe und E-Mails zu Themen des täglichen Lebens schreiben und dabei auf die Erzählungen, Berichte, Gefühle, Standpunkte meiner Partnerinnen und Partner eingehen.';
$string['schule_de_wr_b2_3'] = 'Ich kann formelle und halbformelle Briefe schreiben, z.B. ein Bewerbungsschreiben, eine Anfrage oder einen Leserbrief.';
$string['schule_de_wr_b2_4'] = 'Ich kann Informationen aus verschiedenen Quellen und Medien schriftlich zusammenfassen und verständlich präsentieren.';
$string['schule_de_wr_b2_5'] = 'Ich kann den Inhalt von Filmen und Büchern oder Gesprächen klar und sachgerecht wiedergeben und Erlebtes oder Beobachtetes genau zusammenfassen.';
$string['schule_de_wr_b2_6'] = 'Ich kann ein Thema erörtern und dabei Gründe für oder gegen einen bestimmten Standpunkt darlegen sowie Vor- und Nachteile erläutern.';
$string['schule_de_wr_b2_7'] = 'Ich kann mit Hilfe von Mustern einfache Texte literarischer Genres schreiben.';
$string['schule_de_wr_c1_1'] = 'Ich kann eigene Erlebnisse und Erfahrungen klar, verständlich und lebendig wiedergeben.';
$string['schule_de_wr_c1_2'] = 'Ich kann private und formelle Briefe im jeweils angemessenen Ton abfassen.';
$string['schule_de_wr_c1_3'] = 'Ich kann zu einem Ereignis oder Sachverhalt Stellung nehmen, Standpunkte darstellen und erörtern und meine Position begründet und nachvollziehbar darstellen.';
$string['schule_de_wr_c1_4'] = 'Ich kann literarische Texte, Dramen und Filme zusammenfassen, untersuchen und begründet darlegen, wie ich sie aus meiner Sicht deute.';
$string['schule_de_wr_c2_1'] = 'Ich kann ohne Mühe anspruchsvolle private und formelle Briefe schreiben.';
$string['schule_de_wr_c2_2'] = 'Ich kann gut strukturierte Berichte, Artikel und Stellungnahmen verfassen.';
$string['schule_de_wr_c2_3'] = 'Ich kann Zusammenfassungen und Besprechungen von Fachliteratur und künstlerischen Werken schreiben.';
$string['schule_de_sp_a1_1'] = 'Ich kann etwas über meine Familie, meine Freunde und Freundinnen erzählen.';
$string['schule_de_sp_a1_2'] = 'Ich kann über mich, meinen Schulalltag und meine Freizeit sprechen.';
$string['schule_de_sp_a2_1'] = 'Ich kann in zusammenhängenden Sätzen über mich, meine Familie und meine Freunde und Freundinnen berichten.';
$string['schule_de_sp_a2_2'] = 'Ich kann über meinen Tagesablauf berichten.';
$string['schule_de_sp_a2_3'] = 'Ich kann über meine Hobbys und Interessen berichten und Vorlieben und Abneigungen äußern.';
$string['schule_de_sp_a2_4'] = 'Ich kann über ein Ereignis oder ein Erlebnis in kurzen, einfachen Sätzen berichten.';
$string['schule_de_sp_a2_5'] = 'Ich kann Alltagsthemen kurz, einfach und zusammenhängend präsentieren, wenn ich mich darauf vorbereitet habe.';
$string['schule_de_sp_a2_6'] = 'Ich kann kurze gelesene oder gehörte Texte mit einfachen Worten wiedergeben.';
$string['schule_de_sp_a2_7'] = 'Ich kann mit Hilfe vorgegebener Wörter oder Bilder einfache Geschichten erzählen, wenn ich mich darauf vorbereitet habe.';
$string['schule_de_sp_b1_1'] = 'Ich kann erzählen oder berichten, was ich erlebt, beobachtet oder unternommen habe.';
$string['schule_de_sp_b1_2'] = 'Ich kann über Musik, Filme, Bücher und Fernsehsendungen sprechen und meine Meinung dazu sagen.';
$string['schule_de_sp_b1_3'] = 'Ich kann meine Absichten, Pläne und Ziele darlegen und begründen.';
$string['schule_de_sp_b1_4'] = 'Ich kann Informationen wiedergeben, die ich gehört oder gelesen habe.';
$string['schule_de_sp_b1_5'] = 'Ich kann gut vorbereitete Kurzpräsentationen durchführen und durch meine Darstellung das Zuhören leicht und interessant machen.';
$string['schule_de_sp_b1_6'] = 'Ich kann mit Hilfe von Stichwörtern oder Bildern Geschichten erzählen.';
$string['schule_de_sp_b2_1'] = 'Ich kann spontan erzählen und berichten, was ich erlebt, erfahren, mir ausgedacht habe oder was ich vorhabe.';
$string['schule_de_sp_b2_2'] = 'Ich kann die Handlung und Abfolge von Ereignissen in Büchern, Filmen, Fernsehsendungen, Theaterstücken usw. zusammenfassen.';
$string['schule_de_sp_b2_3'] = 'Ich kann längere Texte und kurze Auszüge aus Nachrichten, Interviews, Reportagen usw., die Stellungnahmen und Diskussionen enthalten, zusammenfassen.';
$string['schule_de_sp_b2_4'] = 'Ich kann meinen Standpunkt ausführlich und klar gegliedert darstellen und begründen, durch geeignete Beispiele stützen und Vor- und Nachteile sowie Alternativen aufzeigen.';
$string['schule_de_sp_b2_5'] = 'Ich kann zu vielen Themen meines Interesses detaillierte Beschreibungen und Berichte geben.';
$string['schule_de_sp_b2_6'] = 'Ich kann Abläufe beschreiben und komplexere Arbeitsanleitungen und Anweisungen geben.';
$string['schule_de_sp_b2_7'] = 'Ich kann mit Hilfe weniger Stichwörter Geschichten erzählen.';
$string['schule_de_sp_c1_1'] = 'Ich kann fließend in allen Einzelheiten über meine Erlebnisse, Ideen und Pläne berichten.';
$string['schule_de_sp_c1_2'] = 'Ich kann lange, anspruchsvolle Texte mündlich zusammenfassen und wichtige Einzelheiten dabei genau wiedergeben.';
$string['schule_de_sp_c1_3'] = 'Ich kann komplexe Sachverhalte klar und detailliert darstellen.';
$string['schule_de_sp_c1_4'] = 'Ich kann mündlich etwas ausführlich darstellen oder berichten, dabei inhaltliche Aspekte zueinander in Bezug setzen, bestimmte Gesichtspunkte genauer ausführen und den Beitrag angemessen abschließen.';
$string['schule_de_sp_c1_5'] = 'Ich kann in meinem Fach- und Interessensgebiet einen klar gegliederten Vortrag halten, dabei, wenn nötig, vom vorbereiteten Text abweichen und spontan auf Fragen von Zuhörerinnen und Zuhörern reagieren.';
$string['schule_de_sp_c1_6'] = 'Ich kann Geschichten interessant und lebendig erzählen.';
$string['schule_de_sp_c2_1'] = 'Ich kann mühelos und detailliert meine Erfahrungen, Erlebnisse, Ideen und Pläne darstellen und dabei auch feinere Bedeutungsnuancen genau zum Ausdruck bringen.';
$string['schule_de_sp_c2_2'] = 'Ich kann Informationen aus verschiedenen Quellen mündlich zusammenfassen und die dabei enthaltenen Argumente und Sachverhalte in einer klaren, zusammenhängenden Darstellung wiedergeben.';
$string['schule_de_sp_c2_3'] = 'Ich kann Gedanken und Standpunkte sehr flexibel vortragen und mich auch zu abstrakten, schwierigen Themen spontan und flüssig äußern.';
$string['schule_de_sp_c2_4'] = 'Ich kann ein komplexes Thema sprachlich und inhaltlich gut strukturiert präsentieren. Dabei erleichtere ich meinen Zuhörerinnen und Zuhörern das Verständnis, indem ich meine Ausführungen logisch aufbaue und auf wichtige Aspekte gezielt verweise.';
$string['schule_de_sp_c2_5'] = 'Ich kann mühelos Geschichten frei erzählen und sie interessant und lebendig darstellen.';
$string['schule_de_si_a1_1'] = 'Ich kann jemanden begrüßen und verabschieden, und ich kann etwas über mich erzählen.';
$string['schule_de_si_a1_2'] = 'Ich kann einem aneren Menschen Fragen stellen, um ihn besser kennen zu lernen. Ich auch wiedergeben, was er über sich sagt.';
$string['schule_de_si_a1_3'] = 'Ich weiß, was ich sagen kann, wenn ich andere Menschen im Alltag und zu Festtagen treffe.';
$string['schule_de_si_a1_4'] = 'Ich kann Fragen über den Tages- und Jahresablauf stellen und beantworten.';
$string['schule_de_si_a1_5'] = 'Ich kann mich beim Einkauf verständigen.';
$string['schule_de_si_a1_6'] = 'Ich kann sagen, wo sich etwas befindet.';
$string['schule_de_si_a1_7'] = 'Ich kann um etwas bitten.';
$string['schule_de_si_a1_8'] = 'Ich kann sagen, dass ich etwas nicht verstanden habe.';
$string['schule_de_si_a2_1'] = 'Ich kann mich mit anderen über mich, meine Familie, Schule und Freizeit unterhalten.';
$string['schule_de_si_a2_2'] = 'Ich kann in einfachen Worten meine Meinung zu einem bestimmten Thema äußern.';
$string['schule_de_si_a2_3'] = 'Ich kann mich mit anderen verabreden, andere einladen und auf Einladungen reagieren.';
$string['schule_de_si_a2_4'] = 'Ich kann sagen, ob ich mit etwas einverstanden bin oder nicht, und auch eigene Vorschläge machen.';
$string['schule_de_si_a2_5'] = 'Ich kann mich an Kiosken, in Geschäften und in einem Restaurant darüber verständigen, was ich haben oder wissen möchte.';
$string['schule_de_si_a2_6'] = 'Ich kann am Schalter (z.B. Post, Bank, Flughafen, Bahnhof) einfache Informationen erfragen.';
$string['schule_de_si_a2_7'] = 'Ich kann Auskünfte über Ort, Zeit und Weg erfragen und geben.';
$string['schule_de_si_b1_1'] = 'Ich kann viele Alltagssituationen sprachlich bewältigen, z.B. Erkundigungen einholen, Verabredungen treffen oder ein Problem schildern.';
$string['schule_de_si_b1_2'] = 'Ich kann Gespräche über Themen führen, die mich interessieren und über die ich etwas weiß.';
$string['schule_de_si_b1_3'] = 'Ich kann in einer Diskussion zu Themen, mit denen ich mich beschäftigt habe, persönliche Ansichten äußern und Meinungen austauschen.';
$string['schule_de_si_b1_4'] = 'Ich kann meine Meinung äußern und begründen, ich kann zustimmen, höflich widersprechen und Gegenvorschläge einbringen.';
$string['schule_de_si_b1_5'] = 'Ich kann Gefühle wie Überraschung, Freude, Trauer, Interesse und Gleichgültigkeit mit einigen wenigen Redewendungen ausdrücken. Ich kann auch auf entsprechende Gefühlsäußerungen anderer reagieren.';
$string['schule_de_si_b2_1'] = 'Ich kann spontan ein Gespräch über ein Thema von allgemeinem Interesse, auch mit Muttersprachlerinnen und Muttersprachlern, beginnen, aufrechterhalten und beenden.';
$string['schule_de_si_b2_2'] = 'Ich kann in Diskussionen meinen Standpunkt vertreten und auf Gegenargumente im Einzelnen eingehen, wenn es sich um Sachverhalte handelt, die ich kenne.';
$string['schule_de_si_b2_3'] = 'Ich kann in Gesprächen und Diskussionen Absichten, Wünsche, Einwände, Bedenken und Gegenvorschläge höflich vorbringen. Dabei kann ich begründen, warum ich mit etwas nicht einverstanden bin oder mich missverstanden fühle, und ich kann über eine Regelung oder Lösung verhandeln.';
$string['schule_de_si_b2_4'] = 'Ich kann meine Gefühle ausdrücken und hervorheben, was für mich persönlich an Ereignissen und Erfahrungen bedeutsam ist.';
$string['schule_de_si_c1_1'] = 'Ich kann auch in lebhaften Gesprächen mit Muttersprachlerinnen und Muttersprachlern gut mithalten, selbst wenn Themen besprochen werden, die mir weniger vertraut sind.';
$string['schule_de_si_c1_2'] = 'Ich kann meine Gedanken und Meinungen präzise und klar ausdrücken, meine eigenen Beiträge auf die anderer Gesprächsteilnehmer beziehen und Ergebnisse zusammenfassen und erläutern.';
$string['schule_de_si_c1_3'] = 'Ich kann überzeugend eine Position vertreten, Fragen und Kommentare beantworten und auch auf umfangreiche Gegenargumente spontan und flexibel reagieren.';
$string['schule_de_si_c1_4'] = 'Ich kann mich über meine Gefühle und Erfahrungen treffend und situationsgerecht äußern und in unterschiedlichen Situationen auf die Empfindungen und Gedanken verschiedener Gesprächspartner angemessen reagieren.';
$string['schule_de_si_c2_1'] = 'Ich kann sprachliche Situationen jeglicher Art sicher bewältigen.';
$string['schule_de_si_c2_2'] = 'Ich kann mich mühelos an allen Gesprächen und Diskussionen mit Muttersprachlerinnen und Muttersprachlern beteiligen.';
$string['schule_de_si_c2_3'] = 'Ich kann in Diskussionen und Gesprächen mühelos meinen Standpunkt vertreten und dabei jederzeit auf umfangreiche Fragen, Argumente und Einwände anderer flexibel und wirkungsvoll reagieren. Dabei kann ich auch vielschichtige Überlegungen und Haltungen präzise und deutlich formulieren und sehr umfangreiche Ergebnisse bündig zusammenfassen und erläutern.';
$string['schule_de_si_c2_4'] = 'Ich kann meine Gefühle und Erfahrungen so darstellen, dass auch feinere Bedeutungsnuancen deutlich werden und kann mich mühelos und situationsgerecht auf die Empfindungen und Gedanken verschiedener Gesprächspartner einstellen.';


?>
