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
$string['mychecklistdescription'] = 'Display your checklist for a selected language';

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

//languages
$string['language.ar'] = 'Arabic';
$string['language.ca'] = 'Catalan';
$string['language.de'] = 'German';
$string['language.en'] = 'English';
$string['language.eo'] = 'Esperanto';
$string['language.es'] = 'Spanish';
$string['language.fi'] = 'Finnish';
$string['language.fr'] = 'French';
$string['language.he'] = 'Hebrew';
$string['language.hu'] = 'Hungarian';
$string['language.it'] = 'Italian';
$string['language.ja'] = 'Japanese';
$string['language.la'] = 'Latin';
$string['language.nl'] = 'Dutch';
$string['language.pl'] = 'Polish';
$string['language.pt'] = 'Portuguese';
$string['language.ru'] = 'Russian';
$string['language.sv'] = 'Swedish';
$string['language.tr'] = 'Turkish';
$string['language.zh'] = 'Chinese';

//descriptor sets
$string['descriptorset.cercles'] = 'CercleS';
$string['descriptorset.elc'] = 'ELC';
$string['descriptorset.schule'] = 'School';

//evaluation levels
$string['eval0'] = 'not at all';
$string['eval1'] = 'satisfactory';
$string['eval2'] = 'very good';

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
 * descriptors ELC 
 */
 
 //Listening
$string['elc_li_a1_1'] = 'I can understand when someone speaks very slowly to me and articulates carefully, with long pauses for me to assimilate meaning.';
$string['elc_li_a1_2'] = 'I can understand simple directions on how to get from X to Y, by foot or public transport.';
$string['elc_li_a1_3'] = 'I can understand questions and instructions addressed carefully and slowly to me and follow short, simple directions.';
$string['elc_li_a1_4'] = 'I can understand numbers, prices and times.';

$string['elc_li_a2_1'] = 'I can understand what is said clearly, slowly and directly to me in simple everyday conversation; it is possible to make me understand, if the speaker can take the trouble.';
$string['elc_li_a2_2'] = 'I can generally identify the topic of discussion around me when people speak slowly and clearly.';
$string['elc_li_a2_3'] = 'I can understand phrases, words and expressions related to areas of most immediate priority (e.g. very basic personal and family information, shopping, local area, employment).';
$string['elc_li_a2_4'] = 'I can grasp the main point in short, clear, simple messages and announcements.';
$string['elc_li_a2_5'] = 'I can understand the essential information in short recorded passages dealing with predictable everyday matters provided they are spoken slowly and clearly.';
$string['elc_li_a2_6'] = 'I can identify the main point of TV news items reporting events, accidents etc. when the visual supports the commentary.';

$string['elc_li_b1_1'] = 'I can follow clearly articulated speech directed at me in everyday conversation, though I sometimes have to ask for repetition of particular words and phrases.';
$string['elc_li_b1_2'] = 'I can generally follow the main points of extended discussion around me, provided speech is clearly articulated in standard dialect.';
$string['elc_li_b1_3'] = 'I can listen to a short narrative and form hypotheses about what will happen next.';
$string['elc_li_b1_4'] = 'I can understand the main points of radio news bulletins and simpler recorded material on topics of personal interest delivered relatively slowly and clearly.';
$string['elc_li_b1_5'] = 'I can grasp the main points in TV programmes on familiar topics when the delivery is relatively slow and clear.';
$string['elc_li_b1_6'] = 'I can understand simple technical information, such as operating instructions for everyday equipment.';
$string['elc_li_b1_7'] = 'I can understand the main points of a discussion on familiar matters within my own field (e.g., in a seminar, at a round table, or during a television discussion), provided that the participants speak clearly and use standard language.';
$string['elc_li_b1_8'] = 'I can take notes on the main points of a lecture which are precise enough for my own use at a later date, provided the topic is within my field of study and the talk is clear and well-structured.';

$string['elc_li_b2_1'] = 'I can understand in detail what is said to me in standard spoken language even in a noisy environment.';
$string['elc_li_b2_2'] = 'I can follow a lecture or talk within my own field, provided the subject matter is familiar and the presentation straightforward and clearly structured.';
$string['elc_li_b2_3'] = 'I can understand most radio documentaries delivered in standard language and can identify the speaker’s mood, tone etc.';
$string['elc_li_b2_4'] = 'I can understand TV documentaries, live interviews, talk shows, plays and the majority of films in standard dialect.';
$string['elc_li_b2_5'] = 'I can understand the main ideas of complex speech on both concrete and abstract topics delivered in a standard dialect, including technical discussions in my field of specialisation.';
$string['elc_li_b2_6'] = 'I can use a variety of strategies to achieve comprehension, including listening for main points and checking comprehension by using contextual clues.';
$string['elc_li_b2_7'] = 'I can understand a clearly structured lecture on a familiar topic and take notes on points that strike me as important, although I sometimes get stuck on words and therefore miss part of the information.';

$string['elc_li_c1_1'] = 'I can follow extended speech even when it is not clearly structured and when relationships are only implied and not signalled explicitly.';
$string['elc_li_c1_2'] = 'I can understand a wide range of idiomatic expressions and colloquialisms, appreciating shifts in style and register.';
$string['elc_li_c1_3'] = 'I can extract specific information from even poor quality, audibly distorted public announcements, e.g. in a station, sports stadium etc.';
$string['elc_li_c1_4'] = 'I can understand complex technical information, such as operating instructions, specifications for familiar products and services.';
$string['elc_li_c1_5'] = 'I can understand lectures, talks and reports in my field of professional or academic interest even when they are propositionally and linguistically complex.';
$string['elc_li_c1_6'] = 'I can, without too much effort, understand films which contain a considerable degree of slang and idiomatic usage.';
$string['elc_li_c1_7'] = 'I can understand radio and television programs in my field, even when they are demanding in content and linguistically complex.';
$string['elc_li_c1_8'] = 'I can understand in detail speech on abstract and complex topics of a specialist nature outside my own field, although on occasion I need to confirm details, especially when the accent is unfamiliar.';
$string['elc_li_c1_9'] = 'I can take detailed notes during a lecture on a familiar topic in my field of interest, recording the information so accurately and so closely to the original that they are also useful to other people.';

$string['elc_li_c2_1'] = 'I have no difficulty in understanding any kind of spoken language, whether live or broadcast, even when delivered at fast native speed, provided I have some time to become familiar with the accent.';
$string['elc_li_c2_2'] = 'I can follow specialised lectures and presentations that contain a high degree of colloquial expressions, regional usage, or unfamiliar terminology.';
$string['elc_li_c2_3'] = 'I notice, during a lecture or seminar, what is only implicitly said and alluded to and can take notes on this as well as what the speaker directly expresses.';

//Reading
$string['elc_re_a1_1'] = 'I can understand information about people (place of residence, age, etc.) in newspapers.';
$string['elc_re_a1_2'] = 'I can locate a concert or a film on calendars of public events or posters and identify where it takes place and at what time it starts.';
$string['elc_re_a1_3'] = 'I can understand a questionnaire (entry permit form, hotel registration form) well enough to give the most important information about myself (name, surname, date of birth, nationality).';
$string['elc_re_a1_4'] = 'I can understand words and phrases on signs encountered in everyday life (for instance ”station”, ”car park”, ”no parking”, ”no smoking”, ”keep left”.';
$string['elc_re_a1_5'] = 'I can understand the most important orders in a computer programme such as ”PRINT”, ”SAVE”, ”COPY”, etc.';
$string['elc_re_a1_6'] = 'I can follow short simple written directions (e.g. how to go from X to Y).';
$string['elc_re_a1_7'] = 'I can understand short simple messages on postcards, for example holiday greetings.';
$string['elc_re_a1_8'] = 'In everyday situations I can understand simple messages written by friends or colleagues, for example ”back at 4 o’clock”.';

$string['elc_re_a2_1'] = 'I can identify important information in news summaries or simple newspaper articles in which numbers and names play an important role and which are clearly structured and illustrated.';
$string['elc_re_a2_2'] = 'I can understand a simple personal letter in which the writer tells or asks me about aspects of everyday life.';
$string['elc_re_a2_3'] = 'I can understand simple written messages from friends or colleagues, for example saying when we should meet to play football or asking me to be at work early.';
$string['elc_re_a2_4'] = 'I can find the most important information on leisure time activities, exhibitions, etc. in information leaflets.';
$string['elc_re_a2_5'] = 'I can skim small advertisements in newspapers, locate the heading or column I want and identify the most important pieces of information (price and size of apartments, cars, computers).';
$string['elc_re_a2_6'] = 'I can understand simple user’s instructions for equipment (for example, a public telephone).';
$string['elc_re_a2_7'] = 'I can understand feedback messages or simple help indications in computer programmes.';
$string['elc_re_a2_8'] = 'I can understand short narratives about everyday things dealing with topics which are familiar to me if the text is written in simple language.';

$string['elc_re_b1_1'] = 'I can understand the main points in short newspaper articles about current and familiar topics.';
$string['elc_re_b1_2'] = 'I can guess the meaning of single unknown words from the context thus deducing the meaning of expressions if the topic is familiar.';
$string['elc_re_b1_3'] = 'I can skim short texts (for example news summaries) and find relevant facts and information (for example who has done what and where).';
$string['elc_re_b1_4'] = 'I can understand simple messages and standard letters (for example from businesses, clubs or authorities).';
$string['elc_re_b1_5'] = 'In private letters I can understand those parts dealing with events, feelings and wishes well enough to correspond regularly with a pen friend.';
$string['elc_re_b1_6'] = 'I can understand the plot of a clearly structured story and recognise what the most important episodes and events are and what is significant about them.';
$string['elc_re_b1_7'] = 'I can identify the main conclusions in clearly written argumentative texts.';
$string['elc_re_b1_8'] = 'I can read straightforward factual texts on subjects related to my field and interests at a satisfactory level of understanding.';
$string['elc_re_b1_9'] = 'I can scan longer texts in my field in order to locate desired information and also to gather information from different texts or parts of a text in order to complete a specific task.';

$string['elc_re_b2_1'] = 'I can rapidly grasp the content and the significance of news, articles and reports on topics connected with my interests or my job, and decide if a closer reading is worthwhile.';
$string['elc_re_b2_2'] = 'I can read and understand articles and reports on current problems in which the writers express specific attitudes and points of view.';
$string['elc_re_b2_3'] = 'I can understand in detail texts within my field of interest or the area of my academic or professional speciality.';
$string['elc_re_b2_4'] = 'I can understand specialised articles outside my own field if I can occasionally check with a dictionary.';
$string['elc_re_b2_5'] = 'I can read reviews dealing with the content and criticism of cultural topics (films, theatre, books, concerts) and summarise the main points.';
$string['elc_re_b2_6'] = 'I can read letters on topics within my areas of academic or professional speciality or interest and grasp the most important points.';
$string['elc_re_b2_7'] = 'I can quickly look through a manual (for example, for a computer programme) and find and understand the relevant explanations and advice for a specific problem.';
$string['elc_re_b2_8'] = 'I can understand, in a narrative or play, the motives for the characters’ actions and their consequences for the development of the plot.';

$string['elc_re_c1_1'] = 'I can understand fairly long demanding texts and summarise them orally.';
$string['elc_re_c1_2'] = 'I can read complex reports, analyses and commentaries where opinions, viewpoints and implications are discussed.';
$string['elc_re_c1_3'] = 'I can extract information, ideas and opinions from highly specialised texts in my own field, for example, research reports.';
$string['elc_re_c1_4'] = 'I can understand long complex instructions, for example, for the use of a new piece of equipment, even if these are not related to my job or field of interest, provided I have enough time to reread them.';
$string['elc_re_c1_5'] = 'I can read any correspondence with occasional use of a dictionary.';
$string['elc_re_c1_6'] = 'I can read contemporary literary texts with ease.';
$string['elc_re_c1_7'] = 'I can go beyond the concrete plot of a narrative and grasp implicit meanings, ideas, and connections.';
$string['elc_re_c1_8'] = 'I can recognise the social, political, or historical background of a literary work.';

$string['elc_re_c2_1'] = 'I can recognise puns and appreciate texts whose real meaning is not explicit (for example irony, satire).';
$string['elc_re_c2_2'] = 'I can understand texts written in a very colloquial style and containing many idiomatic expressions or slang.';
$string['elc_re_c2_3'] = 'I can understand manuals, regulations and contracts even within unfamiliar fields.';
$string['elc_re_c2_4'] = 'I can understand contemporary and classical literary texts of different genres (poetry, prose, drama).';
$string['elc_re_c2_5'] = 'I can read texts such as literary columns or satirical glosses where much is said in an indirect and ambiguous way and which contain hidden value judgements.';
$string['elc_re_c2_6'] = 'I can recognise different stylistic means (puns, metaphors, symbols, connotations, ambiguity) and appreciate and evaluate their function within the text.';
$string['elc_re_c2_7'] = 'I can understand in detail lengthy and complex scientific texts, whether or not they relate to my own field.';

//Spoken Interaction
$string['elc_si_a1_1'] = 'I can introduce somebody and use basic greeting and leave-taking expressions.';
$string['elc_si_a1_2'] = 'I can ask and answer simple questions, initiate and respond to simple statements in areas of immediate need or on very familiar topics.';
$string['elc_si_a1_3'] = 'I can make myself understood in a simple way but I am dependent on my partner being prepared to repeat more slowly and rephrase what I say and to help me to say what I want.';
$string['elc_si_a1_4'] = 'I can make simple purchases where pointing or other gestures can support what I say.';
$string['elc_si_a1_5'] = 'I can handle numbers, quantities, cost and time.';
$string['elc_si_a1_6'] = 'I can ask people for things and give people things.';
$string['elc_si_a1_7'] = 'I can ask people questions about where they live, people they know, things they have, etc. and answer such questions addressed to me provided they are articulated slowly and clearly.';
$string['elc_si_a1_8'] = 'I can indicate time by such phrases as ”next week”, ”last Friday”, ”in November”, ”three o clock”.';

$string['elc_si_a2_1'] = 'I can make simple transactions in shops, post offices or banks.';
$string['elc_si_a2_2'] = 'I can use public transport: buses, trains, and taxis, ask for basic information and buy tickets.';
$string['elc_si_a2_3'] = 'I can get simple information about travel.';
$string['elc_si_a2_4'] = 'I can order something to eat or drink.';
$string['elc_si_a2_5'] = 'I can make simple purchases by stating what I want and asking the price.';
$string['elc_si_a2_6'] = 'I can ask for and give directions referring to a map or plan.';
$string['elc_si_a2_7'] = 'I can ask how people are and react to news.';
$string['elc_si_a2_8'] = 'I can make and respond to invitations.';
$string['elc_si_a2_9'] = 'I can make and accept apologies.';
$string['elc_si_a2_10'] = 'I can say what I like and dislike.';
$string['elc_si_a2_11'] = 'I can discuss with other people what to do, where to go and make arrangements to meet.';
$string['elc_si_a2_12'] = 'I can ask people questions about what they do at work and in free time, and answer such questions addressed to me.';

$string['elc_si_b1_1'] = 'I can start, maintain and close simple face-to-face conversation on topics that are familiar or of personal interest.';
$string['elc_si_b1_2'] = 'I can maintain a conversation or discussion but may sometimes be difficult to follow when trying to say exactly what I would like to.';
$string['elc_si_b1_3'] = 'I can deal with most situations likely to arise when making travel arrangements through an agent or when actually travelling.';
$string['elc_si_b1_4'] = 'I can express and respond to feelings such as surprise, happiness, sadness, interest and indifference. ';
$string['elc_si_b1_5'] = 'I can give or seek personal views and opinions in an informal discussion with friends.';
$string['elc_si_b1_6'] = 'I can agree and disagree politely.';
$string['elc_si_b1_7'] = 'I can speak about topics in my field in informal situations with colleagues or fellow students.';
$string['elc_si_b1_8'] = 'I can manage most discussions involved in the organisation of my studies, either face to face or by telephone.';

$string['elc_si_b2_1'] = 'I can initiate, maintain and end discourse naturally with effective turn-taking.';
$string['elc_si_b2_2'] = 'I can exchange considerable quantities of detailed factual information on matters within my fields of interest.';
$string['elc_si_b2_3'] = 'I can convey degrees of emotion and highlight the personal significance of events and experiences.';
$string['elc_si_b2_4'] = 'I can engage in extended conversation in a clearly participatory fashion on most general topics.';
$string['elc_si_b2_5'] = 'I can account for and sustain my opinions in discussion by providing relevant explanations, arguments and comments.';
$string['elc_si_b2_6'] = 'I can contribute to a discussion on familiar topics by confirming comprehension, inviting others in, etc.';
$string['elc_si_b2_7'] = 'I can carry out a prepared interview, checking and confirming information, following up interesting replies.';
$string['elc_si_b2_8'] = 'I can actively participate in conversations on specialised or cultural topics, whether during or outside of courses.';
$string['elc_si_b2_9'] = 'I can efficiently solve problems arising from the organisation of my studies, for example, with teachers and the administration.';

$string['elc_si_c1_1'] = 'I can keep up with an animated conversation between native speakers.';
$string['elc_si_c1_2'] = 'I can use the language fluently, accurately, and effectively on a wide range of general, professional, or academic topics.';
$string['elc_si_c1_3'] = 'I can use language flexibly and effectively for social purposes, including emotional, allusive and joking usage.';
$string['elc_si_c1_4'] = 'I can express my ideas and opinions clearly and precisely and can present and respond to complex lines of reasoning convincingly.';

$string['elc_si_c2_1'] = 'I can take part effortlessly in all conversations and discussions with native speakers.';
$string['elc_si_c2_2'] = 'I have a good command of idiomatic expressions and colloquialisms as well as the specialised language of my field, with connotative levels of meaning. I can also convey finer shades of meaning.';
$string['elc_si_c2_3'] = 'I can hold my own in formal discussions of complex issues, arguing articulately and persuasively and without being at a disadvantage compared with native speakers.';
$string['elc_si_c2_4'] = 'I can handle difficult and even hostile questioning after a speech or a presentation.';
//$string['elc_si_c2_5'] = 'Ich kann Informationen aus verschiedenen Quellen mündlich zusammenfassen und dabei die enthaltenen Argumente und Sachverhalte in einer klaren zusammenhängenden Darstellung wiedergeben. ';
//$string['elc_si_c2_6'] = 'Ich kann Gedanken und Standpunkte sehr flexibel vortragen und dabei etwas hervorheben, differenzieren und Mehrdeutigkeit beseitigen. ';
//$string['elc_si_c2_7'] = 'Ich kann sicher und gut verständlich einem Publikum ein komplexes Thema vortragen, mit dem es nicht vertraut ist, und dabei die Rede flexibel den Bedürfnissen des Publikums anpassen und entsprechend strukturieren.';
$string['elc_si_c2_5'] = ' ';
$string['elc_si_c2_6'] = ' ';
$string['elc_si_c2_7'] = ' ';

//Spoken Production
$string['elc_sp_a1_1'] = 'I can give personal information (address, telephone number, nationality, age, family, and hobbies). ';
$string['elc_sp_a1_2'] = 'I can describe where I live.';

$string['elc_sp_a2_1'] = 'I can describe myself, my family and other people.';
$string['elc_sp_a2_2'] = 'I can describe where I live.';
$string['elc_sp_a2_3'] = 'I can give short, basic descriptions of events.';
$string['elc_sp_a2_4'] = 'I can describe my educational background, my present or most recent job.';
$string['elc_sp_a2_5'] = 'I can describe my hobbies and interests in a simple way.';
$string['elc_sp_a2_6'] = 'I can describe past activities and personal experiences (e.g. the last weekend, my last holiday).';

$string['elc_sp_b1_1'] = 'I can narrate a story.';
$string['elc_sp_b1_2'] = 'I can give detailed accounts of experiences, describing feelings and reactions.';
$string['elc_sp_b1_3'] = 'I can describe dreams, hopes and ambitions.';
$string['elc_sp_b1_4'] = 'I can explain and give reasons for my plans, intentions and actions.';
$string['elc_sp_b1_5'] = 'I can relate the plot of a book or film and describe my reactions.';
$string['elc_sp_b1_6'] = 'I can paraphrase short written passages orally in a simple fashion, using the original text wording and ordering.';
$string['elc_sp_b1_7'] = 'I can give straightforward descriptions on a variety of familiar subjects related to my own fields of interest or study.';
$string['elc_sp_b1_8'] = 'I can give a simple, prepared presentation on a familiar topic within my field that is clear and precise enough to be followed without difficulty most of the time and in which the main points can be understood.';

$string['elc_sp_b2_1'] = 'I can give clear, detailed descriptions on a wide range of subjects related to my fields of interest.';
$string['elc_sp_b2_2'] = 'I can understand and summarise orally short extracts from news items, interviews or documentaries containing opinions, argument and discussion.';
$string['elc_sp_b2_3'] = 'I can understand and summarise orally the plot and sequence of events in an extract from a film or play.';
$string['elc_sp_b2_4'] = 'I can construct a chain of reasoned argument, linking my ideas logically.';
$string['elc_sp_b2_5'] = 'I can explain a viewpoint on a topical issue giving the advantages and disadvantages of various options.';
$string['elc_sp_b2_6'] = 'I can speculate about causes, consequences, and hypothetical situations.';
$string['elc_sp_b2_7'] = 'I can give a short talk in my field, either without notes or using keywords.';
$string['elc_sp_b2_8'] = 'I can summarise information and arguments from various written sources and reproduce them orally.';

$string['elc_sp_c1_1'] = 'I can give clear, detailed descriptions of complex subjects.';
$string['elc_sp_c1_2'] = 'I can orally summarise long, demanding texts.';
$string['elc_sp_c1_3'] = 'I can give an extended description or account of something, integrating themes, developing particular points and concluding appropriately.';
$string['elc_sp_c1_4'] = 'I can give a clearly developed presentation on a subject in my fields of personal or professional interest, departing when necessary from the prepared text and spontaneously following up points raised by members of the audience.';

$string['elc_sp_c2_1'] = 'I can summarise orally information from different sources, reconstructing arguments and accounts in a coherent presentation.';
$string['elc_sp_c2_2'] = 'I can present ideas and viewpoints in a very flexible manner in order to give emphasis, to differentiate, and to avoid ambiguity.';
$string['elc_sp_c2_3'] = 'I can present a complex topic confidently and articulately to an audience unfamiliar with it , structuring and adapting the talk flexibly to meet the audience\'s needs.';

// Ergänzen "Strategies"

// Ergänzen "Language Quality"

//Writing
$string['elc_wr_a1_1'] = 'I can fill in a questionnaire with my personal details (job, age, address, hobbies).';
$string['elc_wr_a1_2'] = 'I can write a greeting card, for instance a birthday card.';
$string['elc_wr_a1_3'] = 'I can write a simple postcard (for example with holiday greetings).';
$string['elc_wr_a1_4'] = 'I can write a note to tell somebody where I am or where we are to meet.';
$string['elc_wr_a1_5'] = 'I can write sentences and simple phrases about myself, for example where I live and what I do.';

$string['elc_wr_a2_1'] = 'I can write short, simple notes and messages.';
$string['elc_wr_a2_2'] = 'I can describe an event in simple sentences and report what happened when and where (for example a party or an accident).';
$string['elc_wr_a2_3'] = 'I can write about aspects of my everyday life in simple phrases and sentences (people, places, job, school, family, hobbies).';
$string['elc_wr_a2_4'] = 'I can fill in a questionnaire giving an account of my educational background, my job, my interests and my specific skills.';
$string['elc_wr_a2_5'] = 'I can briefly introduce myself in a letter with simple phrases and sentences (family, school, job, hobbies).';
$string['elc_wr_a2_6'] = 'I can write a short letter using simple expressions for greeting, addressing, asking or thanking somebody.';
$string['elc_wr_a2_7'] = 'I can write simple sentences, connecting them with words such as “and”, “but”, “because”.';
$string['elc_wr_a2_8'] = 'I can use the most important connecting words to indicate the chronological order of events (first, then, after, later).';

$string['elc_wr_b1_1'] = 'I can write simple connected texts on a range of topics within my field of interest and can express personal views and opinions.';
$string['elc_wr_b1_2'] = 'I can write simple texts about experiences or events, for example about a trip, for a school newspaper or a club newsletter.';
$string['elc_wr_b1_3'] = 'I can write personal letters to friends or acquaintances asking for or giving them news and narrating events. ';
$string['elc_wr_b1_4'] = 'I can describe in a personal letter the plot of a film or a book or give an account of a concert.';
$string['elc_wr_b1_5'] = 'In a letter, I can express feelings such as grief, happiness, interest, regret and sympathy.';
$string['elc_wr_b1_6'] = 'I can reply in written form to advertisements and ask for more complete or more specific information about products (for example a car or an academic course).';
$string['elc_wr_b1_7'] = 'I can convey – via fax, e-mail or a circular – short simple factual information to friends or colleagues or ask for information in such a way.';
$string['elc_wr_b1_8'] = 'I can write my CV in summary form.';
$string['elc_wr_b1_9'] = 'I can record the course of a scientific experiment in keywords.';
$string['elc_wr_b1_10'] = 'I can write simple texts in my field, correctly using the most important specialised terms.';

$string['elc_wr_b2_1'] = 'I can write clear and detailed texts (compositions, reports or texts of presentations) on various topics related to my field of interest.';
$string['elc_wr_b2_2'] = 'I can write summaries of articles on topics of general interest.';
$string['elc_wr_b2_3'] = 'I can summarise information from different sources and media.';
$string['elc_wr_b2_4'] = 'I can develop an argument systematically in a composition or report, emphasising decisive points and including supporting details.';
$string['elc_wr_b2_5'] = 'I can write about events and real or fictional experiences in a detailed and easily readable way.';
$string['elc_wr_b2_6'] = 'I can write a short review of a film or a book.';
$string['elc_wr_b2_7'] = 'I can express, in a personal letter or e-mail, different feelings and attitudes and can report the news of the day making clear what – in my opinion – are the important aspects of an event.';
$string['elc_wr_b2_8'] = 'I can write summaries of scientific texts in my field for use at a later date.';
$string['elc_wr_b2_9'] = 'I can write seminar papers on my own, although I must have them checked for linguistic accuracy and appropriateness.';

$string['elc_wr_c1_1'] = 'I can express myself in writing on a wide range of general or professional topics in a clear and user-friendly manner.';
$string['elc_wr_c1_2'] = 'I can present a complex topic in a clear and well-structured way, highlighting the most important points, for example in a composition or a report.';
$string['elc_wr_c1_3'] = 'I can present points of view in a comment on a topic or an event, underlining the main ideas and supporting my reasoning with detailed examples.';
$string['elc_wr_c1_4'] = 'I can put together information from different sources and present it in a coherent summary.';
$string['elc_wr_c1_5'] = 'I can give a detailed description of experiences, feelings and events in a personal letter.';
$string['elc_wr_c1_6'] = 'I can write formally correct letters, for example to complain or to take a stand in favour of or against something.';
$string['elc_wr_c1_7'] = 'I can write texts which show a high degree of grammatical correctness, and vary my vocabulary and style according to the target reader, the kind of text and the topic.';
$string['elc_wr_c1_8'] = 'I can select a style appropriate to the target reader.';
$string['elc_wr_c1_9'] = 'I can use the specialised terms and idiomatic expressions in my field without major difficulty.';

$string['elc_wr_c2_1'] = 'I can write well-structured and easily readable reports and articles on complex topics.';
$string['elc_wr_c2_2'] = 'In a report or an essay I can give a complete account of a topic based on research I have carried out, make a summary of the opinions of others, and give and evaluate detailed information and facts.';
$string['elc_wr_c2_3'] = 'I can write a well-structured review of a paper or a project giving reasons for my opinion.';
$string['elc_wr_c2_4'] = 'I can write a critical review of cultural events (film, music, theatre, literature, radio, TV).';
$string['elc_wr_c2_5'] = 'I can write summaries of factual texts and literary works.';
$string['elc_wr_c2_6'] = 'I can write narratives about experiences in a clear, fluent style appropriate to the genre.';
$string['elc_wr_c2_7'] = 'I can write clear, well-structured, complex letters in an appropriate style, for example an application or request, an offer to authorities, superiors or commercial clients.';
$string['elc_wr_c2_8'] = 'In a letter or an e-mail I can express myself in a consciously ironical, ambiguous and humorous way.';
$string['elc_wr_c2_9'] = 'I can write scientific texts in my field, with a view to being published, that are generally correct and stylistically appropriate.';
$string['elc_wr_c2_10'] = 'I can write a critical essay (e.g., a review) of scientific literature for publication in my field.';
$string['elc_wr_c2_11'] = 'I can take accurate and complete notes during a lecture, seminar, or tutorial.';
$string['elc_wr_c2_12'] = 'I can summarise information from different sources, reconstructing arguments in such a way that the overall result is a coherent presentation.';
$string['elc_wr_c2_13'] = 'I can edit colleagues\' texts, improving them grammatically and stylistically, with little hesitation.';

/*
 * descriptors CercleS
 */
$string['cercles_li_a1_1'] = 'I can understand basic words and phrases about myself and my family when people speak slowly and clearly ';
$string['cercles_li_a1_2'] = 'I can understand simple instructions, directions and comments ';
$string['cercles_li_a1_3'] = 'I can understand the names of everyday objects in my immediate environment ';
$string['cercles_li_a1_4'] = 'I can understand basic greetings and routine phrases (e.g., please, thank you) ';
$string['cercles_li_a1_5'] = 'I can understand simple questions about myself when people speak slowly and clearly ';
$string['cercles_li_a1_6'] = 'I can understand numbers and prices ';
$string['cercles_li_a1_7'] = 'I can understand days of the week and months of the year ';
$string['cercles_li_a1_8'] = 'I can understand times and dates';
$string['cercles_li_a2_1'] = 'I can understand what people say to me in simple everyday conversation when they speak slowly and clearly ';
$string['cercles_li_a2_2'] = 'I can understand everyday words and phrases relating to areas of immediate personal relevance (e.g., family, student life, local environment, employment) ';
$string['cercles_li_a2_3'] = 'I can understand everyday words and phrases relating to areas of personal interest (e.g., hobbies, social life, holidays, music, TV, films, travel) ';
$string['cercles_li_a2_4'] = 'I can grasp the essential elements of clear simple messages and recorded announcements (e.g., on the telephone, at the railway station) ';
$string['cercles_li_a2_5'] = 'I can understand simple phrases, questions and information relating to basic personal needs (e.g., shopping, eating out, going to the doctor) ';
$string['cercles_li_a2_6'] = 'I can follow simple directions (e.g., how to get from X to Y) by foot or public transport ';
$string['cercles_li_a2_7'] = 'I can usually identify the topic of conversation around me when people speak slowly and clearly ';
$string['cercles_li_a2_8'] = 'I can follow changes of topic in factual TV news items and form an idea of the main content ';
$string['cercles_li_a2_9'] = 'I can identify the main point of TV news items reporting events, accidents, etc., if there is visual support';
$string['cercles_li_b1_1'] = 'I can follow the gist of everyday conversation when people speak clearly to me in standard dialect ';
$string['cercles_li_b1_2'] = 'I can understand straightforward factual information about everyday, study- or work-related topics, identifying both general messages and specific details, provided speech is clearly articulated in a generally familiar accent. ';
$string['cercles_li_b1_3'] = 'I can understand the main points of discussions on familiar topics in everyday situations when people speak clearly in standard dialect ';
$string['cercles_li_b1_4'] = 'I can follow a lecture or talk within my own academic or professional field, provided the subject matter is familiar and the presentation straightforward and clearly structured ';
$string['cercles_li_b1_5'] = 'I can catch the main elements of radio news bulletins and recorded audio material on familiar topics delivered in clear standard speech ';
$string['cercles_li_b1_6'] = 'I can follow many TV programmes on topics of personal or cultural interest broadcast in standard dialect ';
$string['cercles_li_b1_7'] = 'I can follow many films in which visuals and action carry much of the storyline, when the language is clear and straightforward ';
$string['cercles_li_b1_8'] = 'I can follow detailed directions, messages and information (e.g., travel arrangements, recorded weather forecasts, answering-machines) ';
$string['cercles_li_b1_9'] = 'I can understand simple technical information, such as operating instructions for everyday equipment';
$string['cercles_li_b2_1'] = 'I can understand standard spoken language on both familiar and unfamiliar topics in everyday situations even in a noisy environment ';
$string['cercles_li_b2_2'] = 'I can with some effort catch much of what is said around me, but may find it difficult to understand a discussion between several native speakers who do not modify their language in any way ';
$string['cercles_li_b2_3'] = 'I can understand announcements and messages on concrete and abstract topics spoken in standard dialect at normal speed ';
$string['cercles_li_b2_4'] = 'I can follow extended talks delivered in standard dialect on cultural, intercultural and social issues (e.g., customs, media, lifestyle, EU) ';
$string['cercles_li_b2_5'] = 'I can follow complex lines of argument, provided these are clearly signposted and the topic is reasonably familiar ';
$string['cercles_li_b2_6'] = 'I can follow the essentials of lectures, talks and reports and other forms of academic or professional presentation in my field ';
$string['cercles_li_b2_7'] = 'I can follow most TV news programmes, documentaries, interviews, talk shows and the majority of films in standard dialect ';
$string['cercles_li_b2_8'] = 'I can follow most radio programmes and audio material delivered in standard dialect and identify the speaker\'s mood, tone, etc. ';
$string['cercles_li_b2_9'] = 'I am sensitive to expressions of feeling and attitudes (e.g., critical, ironic, supportive, flippant, disapproving)';
$string['cercles_li_c1_1'] = 'I can follow extended speech even when it is not clearly structured and when relationships are only implied and not signalled explicitly ';
$string['cercles_li_c1_2'] = 'I can recognize a wide range of idiomatic expressions and colloquialisms, appreciating register shifts ';
$string['cercles_li_c1_3'] = 'I can understand enough to follow extended speech on abstract and complex topics of academic or vocational relevance, though I may need to confirm occasional details, especially if the accent is unfamiliar ';
$string['cercles_li_c1_4'] = 'I can easily follow complex interactions between third parties in group discussion and debate, even on abstract and unfamiliar topics ';
$string['cercles_li_c1_5'] = 'I can follow most lectures, discussions and debates in my academic or professional field with relative ease ';
$string['cercles_li_c1_6'] = 'I can understand complex technical information, such as operating instructions and specifications for familiar products and services ';
$string['cercles_li_c1_7'] = 'I can extract specific information from poor quality, audibly distorted public announcements (e.g., in a station, sports stadium, etc.) ';
$string['cercles_li_c1_8'] = 'I can understand a wide range of recorded and broadcast audio material, including some non-standard usage, and identify finer points of detail including implicit attitudes and relationships between speakers ';
$string['cercles_li_c1_9'] = 'I can follow films employing a considerable degree of slang and idiomatic usage';
$string['cercles_li_c2_1'] = 'I have no difficulty in understanding any kind of spoken language, whether live or broadcast, delivered at fast native speed ';
$string['cercles_li_c2_2'] = 'I can follow specialised lectures and presentations employing a high degree of colloquialism, regional usage or unfamiliar terminology';
$string['cercles_re_a1_1'] = 'I can pick out familiar names, words and phrases in very short simple texts ';
$string['cercles_re_a1_2'] = 'I can understand words and phrases on simple everyday signs and notices (e.g., exit, no smoking, danger, days of the week, times) ';
$string['cercles_re_a1_3'] = 'I can understand simple forms well enough to give basic personal details (e.g., name, address, date of birth) ';
$string['cercles_re_a1_4'] = 'I can understand simple written messages and comments relating to my studies (e.g., "well done", "revise ';
$string['cercles_re_a1_5'] = 'I can understand short simple messages on greeting cards and postcards (e.g., holiday greetings, birthday greetings) ';
$string['cercles_re_a1_6'] = 'I can get an idea of the content of simple informational material if there is pictorial support (e.g., posters, catalogues, advertisements) ';
$string['cercles_re_a1_7'] = 'I can follow short simple written directions (e.g., to go from X to Y)';
$string['cercles_re_a2_1'] = 'I can understand short simple messages and texts containing basic everyday vocabulary relating to areas of personal relevance or interest ';
$string['cercles_re_a2_2'] = 'I can understand everyday signs and public notices (e.g., on the street, in shops, hotels, railway stations) ';
$string['cercles_re_a2_3'] = 'I can find specific predictable information in simple everyday material such as advertisements, timetables, menus, directories, brochures ';
$string['cercles_re_a2_4'] = 'I can understand instructions when expressed in simple language (e.g., how to use a public telephone) ';
$string['cercles_re_a2_5'] = 'I can understand regulations when expressed in simple language (e.g., safety, attendance at lectures) ';
$string['cercles_re_a2_6'] = 'I can understand short simple personal letters giving or requesting information about everyday life or offering an invitation ';
$string['cercles_re_a2_7'] = 'I can identify key information in short newspaper/magazine reports recounting stories or events ';
$string['cercles_re_a2_8'] = 'I can understand basic information in routine letters and messages (e.g., hotel reservations, personal telephone messages)';
$string['cercles_re_b1_1'] = 'I can read straightforward factual texts on subjects related to my field of interest with a reasonable level of understanding ';
$string['cercles_re_b1_2'] = 'I can recognize significant points in straightforward newspaper articles on familiar subjects ';
$string['cercles_re_b1_3'] = 'I can identify the main conclusions in clearly signaled argumentative texts related to my academic or professional field ';
$string['cercles_re_b1_4'] = 'I can understand the description of events, feelings and wishes in personal letters and e¬mails well enough to correspond with a pen friend ';
$string['cercles_re_b1_5'] = 'I can find and understand relevant information in everyday material, such as standard letters, brochures and short official documents ';
$string['cercles_re_b1_6'] = 'I can understand clearly written straightforward instructions (e.g., for using a piece of equipment, for answering questions in an exam) ';
$string['cercles_re_b1_7'] = 'I can scan longer texts in order to locate desired information, and gather information from different parts of a text, or from different texts in order to fulfill a specific task ';
$string['cercles_re_b1_8'] = 'I can follow the plot of clearly structured narratives and modern literary texts';
$string['cercles_re_b2_1'] = 'I can quickly scan through long and complex texts on a variety of topics in my field to locate relevant details ';
$string['cercles_re_b2_2'] = 'I can read correspondence relating to my field of interest and readily grasp the essential meaning ';
$string['cercles_re_b2_3'] = 'I can obtain information, ideas and opinions from highly specialized sources within my academic or professional field ';
$string['cercles_re_b2_4'] = 'I can understand articles on specialized topics using a dictionary and other appropriate reference resources ';
$string['cercles_re_b2_5'] = 'I can quickly identify the content and relevance of news items, articles and reports on a wide range of professional topics, deciding whether closer study is worthwhile ';
$string['cercles_re_b2_6'] = 'I can understand articles and reports concerned with contemporary problems in which the writers adopt particular stances or viewpoints ';
$string['cercles_re_b2_7'] = 'I can understand lengthy complex instructions in my field, including details on conditions or warnings, provided I can reread difficult sections ';
$string['cercles_re_b2_8'] = 'I can readily appreciate most narratives and modern literary texts (e.g., novels, short stories, poems, plays)';
$string['cercles_re_c1_1'] = 'I can understand in detail highly specialized texts in my own academic or professional field, such as research reports and abstracts ';
$string['cercles_re_c1_2'] = 'I can understand any correspondence given the occasional use of a dictionary ';
$string['cercles_re_c1_3'] = 'I can read contemporary literary texts with no difficulty and with appreciation of implicit meanings and ideas ';
$string['cercles_re_c1_4'] = 'I can appreciate the relevant socio-historical or political context of most literary works ';
$string['cercles_re_c1_5'] = 'I can understand detailed and complex instructions for a new machine or procedure, whether or not the instructions relate to my own area of speciality, provided I can reread difficult sections';
$string['cercles_re_c2_1'] = 'I can understand a wide range of long and complex texts, appreciating subtle distinctions of style and implicit as well as explicit meaning ';
$string['cercles_re_c2_2'] = 'I can understand and interpret critically virtually all forms of the written language including abstract, structurally complex, or highly colloquial literary and non-literary writings ';
$string['cercles_re_c2_3'] = 'I can make effective use of complex, technical or highly specialized texts to meet my academic or professional purposes ';
$string['cercles_re_c2_4'] = 'I can critically appraise classical as well as contemporary literary texts in different genres ';
$string['cercles_re_c2_5'] = 'I can appreciate the finer subtleties of meaning, rhetorical effect and stylistic language use in critical or satirical forms of discourse ';
$string['cercles_re_c2_6'] = 'I can understand complex factual documents such as technical manuals and legal contracts';
$string['cercles_wr_a1_1'] = 'I can fill in a simple form or questionnaire with my personal details (e.g., date of birth, address, nationality) ';
$string['cercles_wr_a1_2'] = 'I can write a greeting card or simple postcard ';
$string['cercles_wr_a1_3'] = 'I can write simple phrases and sentences about myself (e.g., where I live, how many brothers and sisters I have) ';
$string['cercles_wr_a1_4'] = 'I can write a short simple note or message (e.g., to tell somebody where I am or where to meet)';
$string['cercles_wr_a2_1'] = 'I can write short simple notes and messages (e.g., saying that someone telephoned, arranging to meet someone, explaining absence) ';
$string['cercles_wr_a2_2'] = 'I can fill in a questionnaire or write a simple curriculum vitae giving personal information ';
$string['cercles_wr_a2_3'] = 'I can write about aspects of my everyday life in simple linked sentences (e.g., family, college life, holidays, work experience) ';
$string['cercles_wr_a2_4'] = 'I can write short simple imaginary biographies and stories about people ';
$string['cercles_wr_a2_5'] = 'I can write very short basic descriptions of events, past activities and personal experiences ';
$string['cercles_wr_a2_6'] = 'I can open and close a simple personal letter using appropriate phrases and greetings ';
$string['cercles_wr_a2_7'] = 'I can write a very simple personal letter (e.g., accepting or offering an invitation, thanking someone for something, apologizing) ';
$string['cercles_wr_a2_8'] = 'I can open and close a simple formal letter using appropriate phrases and greetings ';
$string['cercles_wr_a2_9'] = 'I can write very basic formal letters requesting information (e.g., about summer jobs, hotel accommodation)';
$string['cercles_wr_b1_1'] = 'I can write a description of an event (e.g., a recent trip), real or imagined ';
$string['cercles_wr_b1_2'] = 'I can write notes conveying simple information of immediate relevance to people who feature in my everyday life, getting across comprehensibly the points I feel are important ';
$string['cercles_wr_b1_3'] = 'I can write personal letters giving news, describing experiences and impressions, and expressing feelings ';
$string['cercles_wr_b1_4'] = 'I can take down messages communicating enquiries and factual information, explaining problems ';
$string['cercles_wr_b1_5'] = 'I can write straightforward connected texts and simple essays on familiar subjects within my field, by linking a series of shorter discrete elements into a linear sequence, and using dictionaries and reference resources ';
$string['cercles_wr_b1_6'] = 'I can describe the plot of a film or book, or narrate a simple story ';
$string['cercles_wr_b1_7'] = 'I can write very brief reports to a standard conventionalized format, which pass on routine factual information on matters relating to my field ';
$string['cercles_wr_b1_8'] = 'I can summarize, report and give my opinion about accumulated factual information on familiar matters in my field with some confidence ';
$string['cercles_wr_b1_9'] = 'I can write standard letters giving or requesting detailed information (e.g., replying to an advertisement, applying for a job)';
$string['cercles_wr_b2_1'] = 'I can write clear detailed text on a wide range of subjects relating to my personal, academic or professional interests ';
$string['cercles_wr_b2_2'] = 'I can write letters conveying degrees of emotion and highlighting the personal significance of events and experiences, and commenting on the correspondents news and views ';
$string['cercles_wr_b2_3'] = 'I can express news, views and feelings effectively in writing, and relate to those of others ';
$string['cercles_wr_b2_4'] = 'I can write summaries of articles on topics of general, academic or professional interest, and summarize information from different sources and media ';
$string['cercles_wr_b2_5'] = 'I can write an essay or report which develops an argument, giving reasons to support or negate a point of view, weighing pros and cons ';
$string['cercles_wr_b2_6'] = 'I can summarize and synthesize information and arguments from a number of sources ';
$string['cercles_wr_b2_7'] = 'I can write a short review of a film or book ';
$string['cercles_wr_b2_8'] = 'I can write clear detailed descriptions of real or imaginary events and experiences in a detailed and easily readable way, marking the relationship between ideas ';
$string['cercles_wr_b2_9'] = 'I can write standard formal letters requesting or communicating relevant information, with appropriate use of register and conventions';
$string['cercles_wr_c1_1'] = 'I can express myself fluently and accurately in writing on a wide range of personal, academic or professional topics, varying my vocabulary and style according to the context ';
$string['cercles_wr_c1_2'] = 'I can express myself with clarity and precision in personal correspondence, using language flexibly and effectively, including emotional, allusive and joking usage ';
$string['cercles_wr_c1_3'] = 'I can write clear, well-structured texts on complex subjects in my field, underlining the relevant salient issues, expanding and supporting points of view at some length with subsidiary points, reasons and relevant examples, and rounding off with an appropriate conclusion ';
$string['cercles_wr_c1_4'] = 'I can write clear, detailed, well-structured and developed descriptions and imaginative texts in an assured, personal, natural style appropriate to the reader in mind ';
$string['cercles_wr_c1_5'] = 'I can elaborate my case effectively and accurately in complex formal letters (e.g., registering a complaint, taking a stand against an issue)';
$string['cercles_wr_c2_1'] = 'I can write clear, smoothly-flowing, complex texts relating to my academic or professional work in an appropriate and effective style and a logical structure which helps the reader to find significant points ';
$string['cercles_wr_c2_2'] = 'I can write clear, smoothly-flowing, and fully engrossing stories and descriptions of experience in a style appropriate to the genre adopted ';
$string['cercles_wr_c2_3'] = 'I can write a well-structured critical review of a paper, project or proposal relating to my academic or professional field, giving reasons for my opinion ';
$string['cercles_wr_c2_4'] = 'I can produce clear, smoothly-flowing, complex reports, articles or essays which present a case or elaborate an argument ';
$string['cercles_wr_c2_5'] = 'I can provide an appropriate and effective logical structure which helps the reader to find significant points ';
$string['cercles_wr_c2_6'] = 'I can write detailed critical appraisals of cultural events or literary works ';
$string['cercles_wr_c2_7'] = 'I can write persuasive and well-structured complex formal letters in an appropriate style';
$string['cercles_sp_a1_1'] = 'I can give basic personal information about myself (e.g., age, address, family, subjects of study) ';
$string['cercles_sp_a1_2'] = 'I can use simple words and phrases to describe where I live ';
$string['cercles_sp_a1_3'] = 'I can use simple words and phrases to describe people I know ';
$string['cercles_sp_a1_4'] = 'I can read a very short rehearsed statement (e.g., to introduce a speaker, propose a toast)';
$string['cercles_sp_a2_1'] = 'I can describe myself, my family and other people I know ';
$string['cercles_sp_a2_2'] = 'I can describe my home and where I live ';
$string['cercles_sp_a2_3'] = 'I can say what I usually do at home, at university, in my free time ';
$string['cercles_sp_a2_4'] = 'I can describe my educational background and subjects of study ';
$string['cercles_sp_a2_5'] = 'I can describe plans, arrangements and alternatives ';
$string['cercles_sp_a2_6'] = 'I can give short simple descriptions of events or tell a simple story ';
$string['cercles_sp_a2_7'] = 'I can describe past activities and personal experiences (e.g., what I did at the weekend) ';
$string['cercles_sp_a2_8'] = 'I can explain what I like and don\'t like about something ';
$string['cercles_sp_a2_9'] = 'I can give simple descriptions of things and make comparisons ';
$string['cercles_sp_a2_10'] = 'I can deliver very short rehearsed announcements of predictable learnt content ';
$string['cercles_sp_a2_11'] = 'I can give a short rehearsed presentation on a familiar subject in my academic or professional field';
$string['cercles_sp_b1_1'] = 'I can give a reasonably fluent description of a subject within my academic or professional field, presenting it as a linear sequence of points ';
$string['cercles_sp_b1_2'] = 'I can narrate a story or relate the plot of a film or book ';
$string['cercles_sp_b1_3'] = 'I can describe personal experiences, reactions, dreams, hopes, ambitions, real, Imagined or unexpected events ';
$string['cercles_sp_b1_4'] = 'I can briefly give reasons and explanations for opinions, plans and actions ';
$string['cercles_sp_b1_5'] = 'I can develop an argument well enough to be followed without difficulty most of the time ';
$string['cercles_sp_b1_6'] = 'I can give a simple summary of short written texts ';
$string['cercles_sp_b1_7'] = 'I can give detailed accounts of problems and incidents (e.g., reporting a theft, traffic accident) ';
$string['cercles_sp_b1_8'] = 'I can deliver short rehearsed announcements and statements on everyday matters within my field ';
$string['cercles_sp_b1_9'] = 'I can give a short and straightforward prepared presentation on a chosen topic in my academic or professional field in a reasonably clear and precise manner';
$string['cercles_sp_b2_1'] = 'I can give clear detailed descriptions on a wide range of subjects relating to my field, expanding and supporting ideas with subsidiary points and relevant examples ';
$string['cercles_sp_b2_2'] = 'I can explain a viewpoint on a topical issue, giving the advantages and disadvantages of various options ';
$string['cercles_sp_b2_3'] = 'I can develop a clear coherent argument, linking ideas logically and expanding and supporting my points with appropriate examples ';
$string['cercles_sp_b2_4'] = 'I can outline an issue or a problem clearly, speculating about causes, consequences and hypothetical situations ';
$string['cercles_sp_b2_5'] = 'I can summarize short discursive or narrative material (e.g., written, radio, television) ';
$string['cercles_sp_b2_6'] = 'I can deliver announcements on most general topics with a degree of clarity, fluency and spontaneity which causes no strain or inconvenience to the listener ';
$string['cercles_sp_b2_7'] = 'I can give a clear, systematically developed presentation on a topic in my field, with highlighting of significant points and relevant supporting detail ';
$string['cercles_sp_b2_8'] = 'I can depart spontaneously from a prepared text and follow up points raised by an audience';
$string['cercles_sp_c1_1'] = 'I can give clear detailed descriptions of complex subjects in my field ';
$string['cercles_sp_c1_2'] = 'I can elaborate a detailed argument or narrative, integrating sub-themes, developing particular points and rounding off with an appropriate conclusion ';
$string['cercles_sp_c1_3'] = 'I can give a detailed oral summary of long and complex texts relating to my area of study ';
$string['cercles_sp_c1_4'] = 'I can deliver announcements fluently, almost effortlessly, using stress and intonation to convey finer shades of meaning precisely ';
$string['cercles_sp_c1_5'] = 'I can give a clear, well-structured presentation on a complex subject in my field, expanding and supporting points of view with appropriate reasons and examples';
$string['cercles_sp_c2_1'] = 'I can produce clear, smoothly-flowing well-structured speech with an effective logical structure which helps the recipient to notice and remember significant points ';
$string['cercles_sp_c2_2'] = 'I can give clear, fluent, elaborate and often memorable descriptions ';
$string['cercles_sp_c2_3'] = 'I can summarize and synthesize information and ideas from a variety of specialized sources in my field in a clear and flexible manner ';
$string['cercles_sp_c2_4'] = 'I can present a complex topic in my field confidently and articulately, and can handle difficult and even hostile questioning';
$string['cercles_si_a1_1'] = 'I can say basic greetings and phrases (e.g., please, thank you), ask how someone is and say how I am ';
$string['cercles_si_a1_2'] = 'I can say who I am, ask someone\'s name and introduce someone ';
$string['cercles_si_a1_3'] = 'I can say I don\'t understand, ask people to repeat what they say or speak more slowly, attract attention and ask for help ';
$string['cercles_si_a1_4'] = 'I can ask how to say something in the language or what a word means ';
$string['cercles_si_a1_5'] = 'I can ask and answer simple direct questions on very familiar topics (e.g., family, student life) with help from the person I am talking to ';
$string['cercles_si_a1_6'] = 'I can ask people for things and give people things ';
$string['cercles_si_a1_7'] = 'I can handle numbers, quantities, cost and time ';
$string['cercles_si_a1_8'] = 'I can make simple purchases, using pointing and gestures to support what I say ';
$string['cercles_si_a1_9'] = 'I can reply in an interview to simple direct questions about personal details if these are spoken very slowly and clearly in standard dialect';
$string['cercles_si_a2_1'] = 'I can handle short social exchanges and make myself understood if people help me ';
$string['cercles_si_a2_2'] = 'I can participate in short conversations in routine contexts on topics of interest ';
$string['cercles_si_a2_3'] = 'I can make and respond to Invitations, suggestions, apologies and requests for permission ';
$string['cercles_si_a2_4'] = 'I can say what I like or dislike, agree or disagree with people, and make comparisons ';
$string['cercles_si_a2_5'] = 'I can express what I feel in simple terms, and express thanks ';
$string['cercles_si_a2_6'] = 'I can discuss what to do, where to go, make arrangements to meet (e.g., in the evening, at the weekend) ';
$string['cercles_si_a2_7'] = 'I can ask and answer simple questions about familiar topics (e.g., weather, hobbies, social life, music, sport) ';
$string['cercles_si_a2_8'] = 'I can ask and answer simple questions about things that have happened (e.g., yesterday, last week, last year) ';
$string['cercles_si_a2_9'] = 'I can handle simple telephone calls (e.g., say who is calling, ask to speak to someone, give my number, take a simple message) ';
$string['cercles_si_a2_10'] = 'I can make simple transactions (e.g., in shops, post offices, railway stations) and order something to eat or drink ';
$string['cercles_si_a2_11'] = 'I can get simple practical information (e.g., asking for directions, booking accommodation, going to the doctor)';
$string['cercles_si_b1_1'] = 'I can readily handle conversations on most topics that are familiar or of personal interest, with generally appropriate use of register ';
$string['cercles_si_b1_2'] = 'I can sustain an extended conversation or discussion but may sometimes need a little help in communicating my thoughts ';
$string['cercles_si_b1_3'] = 'I can take part in routine formal discussion on familiar subjects in my academic or professional field if it is conducted in clearly articulated speech in standard dialect ';
$string['cercles_si_b1_4'] = 'I can exchange, check and confirm factual information on familiar routine and non-routine matters within my field with some confidence ';
$string['cercles_si_b1_5'] = 'I can express and respond to feelings and attitudes (e.g., surprise, happiness, sadness, interest, uncertainty, indifference) ';
$string['cercles_si_b1_6'] = 'I can agree and disagree politely, exchange personal opinions, negotiate decisions and ideas ';
$string['cercles_si_b1_7'] = 'I can express my thoughts about abstract or cultural topics such as music or films, and give brief comments on the views of others ';
$string['cercles_si_b1_8'] = 'I can explain why something is a problem, discuss what to do next, compare and contrast alternatives ';
$string['cercles_si_b1_9'] = 'I can obtain detailed information, messages, instructions and explanations, and can ask for and follow detailed directions ';
$string['cercles_si_b1_10'] = 'I can handle most practical tasks in everyday situations (e.g., making telephone enquiries, asking for a refund, negotiating purchase) ';
$string['cercles_si_b1_11'] = 'I can provide concrete information required in an interview/consultation (e.g., describe symptoms to a doctor), but with limited precision ';
$string['cercles_si_b1_12'] = 'I can take some initiatives in an interview/consultation (e.g., bring up a new subject) but am very dependent on the interviewer to provide support ';
$string['cercles_si_b1_13'] = 'I can use a prepared questionnaire to carry out a structured interview, with some spontaneous follow-up questions';
$string['cercles_si_b2_1'] = 'I can participate fully in conversations on general topics with a degree of fluency and naturalness, and appropriate use of register ';
$string['cercles_si_b2_2'] = 'I can participate effectively in extended discussions and debates on subjects of personal, academic or professional interest, marking clearly the relationship between ideas ';
$string['cercles_si_b2_3'] = 'I can account for and sustain my opinion in discussion by providing relevant explanations, arguments and comments ';
$string['cercles_si_b2_4'] = 'I can express, negotiate and respond sensitively to feelings, attitudes, opinions, tone, viewpoints ';
$string['cercles_si_b2_5'] = 'I can exchange detailed factual information on matters within my academic or professional field ';
$string['cercles_si_b2_6'] = 'I can help along the progress of a project by inviting others to join in, express their opinions, etc. ';
$string['cercles_si_b2_7'] = 'I can cope linguistically with potentially complex problems in routine situations (e.g., complaining about goods and services) ';
$string['cercles_si_b2_8'] = 'I can cope adequately with emergencies (e.g., summon medical assistance, telephone the police or breakdown service) ';
$string['cercles_si_b2_9'] = 'I can handle personal interviews with ease, taking initiatives and expanding ideas with little help or prodding from an interviewer ';
$string['cercles_si_b2_10'] = 'I can carry out an effective, fluent interview, departing spontaneously from prepared questions, following up and probing interesting replies';
$string['cercles_si_c1_1'] = 'I can express myself fluently, accurately and spontaneously on a wide range of general, academic or professional topics ';
$string['cercles_si_c1_2'] = 'I can use language flexibly and effectively for social purposes, including emotional, allusive and joking usage ';
$string['cercles_si_c1_3'] = 'I can participate effectively in extended debates on abstract and complex topics of a specialist nature in my academic or professional field ';
$string['cercles_si_c1_4'] = 'I can easily follow and contribute to complex interactions between third parties in group discussion even on abstract or less familiar topics ';
$string['cercles_si_c1_5'] = 'I can argue a formal position convincingly, responding to questions and comments and answering complex lines of counter argument fluently, spontaneously and appropriately ';
$string['cercles_si_c1_6'] = 'I can participate fully in an interview, as either interviewer or interviewee, fluently expanding and developing the point under discussion, and handling interjections well';
$string['cercles_si_c2_1'] = 'I can understand any native speaker interlocutor, given an opportunity to adjust to a non¬standard accent or dialect ';
$string['cercles_si_c2_2'] = 'I can converse comfortably and appropriately, unhampered by any linguistic limitations in conducting a full social and personal life ';
$string['cercles_si_c2_3'] = 'I can hold my own in formal discussion of complex and specialist issues in my field, putting forward and sustaining an articulate and persuasive argument, at no disadvantage to native speakers ';
$string['cercles_si_c2_4'] = 'I can keep up my side of the dialogue as interviewer or interviewee with complete confidence and fluency, structuring the talk and interacting authoritatively at no disadvantage to a native speaker';

/*
 * descriptors Schule
 */
$string['schule_li_a1_1'] = 'Ich kann verstehen, wenn andere mir Fragen zu meiner Person stellen.';
$string['schule_li_a1_2'] = 'Ich kann verstehen, wenn andere sich selbst vorstellen.';
$string['schule_li_a1_3'] = 'Ich kann Fragen und Informationen zum Tages- und Jahresablauf verstehen.';
$string['schule_li_a1_4'] = 'Ich kann verstehen, wenn ich im Unterricht angesprochen werde.';
$string['schule_li_a1_5'] = 'Ich kann Arbeitsanweisungen verstehen.';
$string['schule_li_a1_6'] = 'Ich kann verstehen, wenn jemand sagt, wo sich etwas befindet und wie weit es entfernt ist.';
$string['schule_li_a1_7'] = 'Ich kann verstehen, wenn jemand sagt, wie ich an einen bestimmten Ort komme.';
$string['schule_li_a1_8'] = 'Ich kann verstehen, wenn jemand sagt, wie teuer etwas ist.';
$string['schule_li_a1_9'] = 'Ich kann einzelne Wörter und Sätze wiedererkennen, wenn andere Leute miteinander sprechen.';
$string['schule_li_a1_10'] = 'Ich kann verstehen, worum es geht, wenn ich einfache Texte und Geschichten - auch von einer CD - höre.';
$string['schule_li_a2_1'] = 'Ich kann verstehen, wenn jemand mit mir über Dinge spricht, die mich betreffen (z.B. Schule, Hobbys, Freizeit, Familie).';
$string['schule_li_a2_2'] = 'Ich kann Gesprächen folgen, wenn sie mit mir, meiner Familie und Dingen zu tun haben, die mich interessieren.';
$string['schule_li_a2_3'] = 'Ich kann genug verstehen, um mich im Alltag (z.B. in einem Geschäft, auf der Post) zurecht zu finden.';
$string['schule_li_a2_4'] = 'Ich kann das Wesentliche bei kurzen, deutlichen Mitteilungen, Anweisungen und Durchsagen verstehen.';
$string['schule_li_a2_5'] = 'Ich kann Texten aus Kassette, CD oder DVD folgen, wenn es um Dinge geht, die ich kenne.';
$string['schule_li_a2_6'] = 'Ich kann auch Einzelheiten verstehen, wenn ich die Texte mehrmals hören kann.';
$string['schule_li_a2_7'] = 'Ich kann einfache Geschichten, Lieder und Gedichte im Großen und Ganzen verstehen.';
$string['schule_li_b1_1'] = 'Ich kann in längeren Alltagsgesprächen den Hauptaussagen folgen.';
$string['schule_li_b1_2'] = 'Ich kann Erzählungen aus dem Alltag verstehen.';
$string['schule_li_b1_3'] = 'Ich kann Anweisungen, Aufforderungen, Auskünfte ohne größere Mühe verstehen und darauf reagieren.';
$string['schule_li_b1_4'] = 'Ich kann Beschreibungen Berichten die wichtigsten Informationen entnehmen.';
$string['schule_li_b1_5'] = 'Ich kann längeren gesprochenen Texten gezielt Einzelinformationen entnehmen.';
$string['schule_li_b1_6'] = 'Ich kann in Radionachrichten oder Tonaufnahmen über vertraute Themen die Hauptpunkte verstehen.';
$string['schule_li_b1_7'] = 'Ich kann in Fernsehsendungen, kurzen Filmen und Clips die Hauptpunkte erfassen, wenn mir die Themen vertraut sind.';
$string['schule_li_b1_8'] = 'Ich kann den Sinn von Geschichten, Liedern und Gedichten verstehen.';
$string['schule_li_b2_1'] = 'Ich kann Geprächen, auch zwischen Muttersprachlern, folgen, wenn sie miteinander Standardsprache sprechen und ich übert den Gesprächsgegenstand einigermaßen Bescheid weiß.';
$string['schule_li_b2_2'] = 'Ich kann unerwartete Ankündigungen und Durchsagen verstehen, wenn die Ansage deutlich und störungsfrei ist.';
$string['schule_li_b2_3'] = 'Ich kann mein Gegenüber am Telefon gut verstehen, wenn Alltägliches besprochen wird oder Themen, die mir vertraut sind.';
$string['schule_li_b2_4'] = 'Ich kann die wichtigsten Aussagen von schwierigeren Redebeiträgen, wie Berichten, Präsentationen und Argumentationen, gut verstehen, wenn Standardsprache gesprochen wird und mir das Thema einigermaßen vertraut ist.';
$string['schule_li_b2_5'] = 'Ich kann die meisten aktuellen Nachrichtensendungen und Reportagen im Fernsehen verstehen.';
$string['schule_li_b2_6'] = 'Ich kann den meisten Spielfilmen und Theaterstücken folgen, sofern Standardsprache gesprochen wird.';
$string['schule_li_b2_7'] = 'Ich kann dem Vortrag von komplexeren Gedichten und Geschichten in Standardsprache folgen.';
$string['schule_li_c1_1'] = 'Ich habe kein Problem, gesprochene Sprache von Muttersprachlerinnen und Muttersprachlern zu verstehen, auch bei ungewohnter Aussprache und unbekannten Redewendungen, sofern ich die Gelegenheit habe nachzufragen.';
$string['schule_li_c1_2'] = 'Ich kann öffentliche Durchsagen im Allgemeinen verstehen.';
$string['schule_li_c1_3'] = 'Ich kann längeren Debatten, Reden und Vorträgen folgen, auch wenn sie nicht klar strukturiert sind und mir die angesprochenen Themen und Inhalte im Vorhinein nicht bekannt sind.';
$string['schule_li_c1_4'] = 'Ich kann Radio- und Fernsehsendungen gut folgen und dabei auch komplexere Informationen und Zusammenhänge verstehen.';
$string['schule_li_c1_5'] = 'Ich kann künstlerischen Darbietungen (Film, Theater, öffentliche Lesung) im Allgemeinen ohne Mühe folgen.';
$string['schule_li_c2_1'] = 'Ich verstehe meine Gesprächspartnerinnen und Gesprächspartner in Alltagsgesprächen, auch am Telefon, mühelos, auch wenn ich mich manchmal erst an einen besonderen Akzent gewöhnen muss.';
$string['schule_li_c2_2'] = 'Ich kann komplexe Redebeiträge in Debatten, Reden und Vorträgen zu unterschiedlichen Themen ohne Mühe verstehen, gleich ob ich sie persönlich oder in den Medien höre.';
$string['schule_li_c2_3'] = 'Ich kann künstlerische Darbietungen in den Medien (Radio, Fernsehen, Kino, Theater) und live mit Genuss verfolgen.';
$string['schule_re_a1_1'] = 'Ich kann herausfinden, worum es auf Plakaten, Prospekten usw. geht.';
$string['schule_re_a1_2'] = 'Ich kann Briefe, Postkarten, E-Mails und SMS verstehen.';
$string['schule_re_a1_3'] = 'Ich kann Notizen und Mitteilungen verstehen.';
$string['schule_re_a1_4'] = 'Ich kann schriftliche Arbeitsaufträge verstehen.';
$string['schule_re_a1_5'] = 'Ich kann bei kurzen Geschichten, Reimen, Gedichten usw. verstehen, worum es geht, wenn mir Bilder dabei helfen.';
$string['schule_re_a2_1'] = 'Ich kann in Fahrplänen, Katalogen, Programmen, Anzeigen usw. Informationen finden, die ich suche (z.B. Ort, Zeit, Preis).';
$string['schule_re_a2_2'] = 'Ich kann persönliche Mitteilungen (SMS, Postkarten, E-Mails, Briefe) und kurze Erlebnisberichte verstehen.';
$string['schule_re_a2_3'] = 'Ich kann geschriebenen Anweisungen (z.B. Hilfstexten in Computerprogrammen, Gebrauchsanweisungen, Rezepten) die wichtigsten Informationen entnehmen.';
$string['schule_re_a2_4'] = 'Ich kann kurze Texte über allgemeine Themen, wie z.B. das Leben in anderen Ländern, im Wesentlichen verstehen.';
$string['schule_re_a2_5'] = 'Ich kann einfachen Geschichten, Gedichten usw. folgen, wenn mir z.B. Schlüsselwörter helfen.';
$string['schule_re_b1_1'] = 'Ich kann private Briefe, Karten und E-Mails verstehen, in denen Gefühle, Wünsche und Erlebnisse beschrieben werden.';
$string['schule_re_b1_2'] = 'Ich kann einfache Mitteilungen und Standardbriefe verstehen (z.B. von Geschäften, Vereinen oder Behörden).';
$string['schule_re_b1_3'] = 'Ich kann einfache Sachtexte zu allgemeinen Themen lesen und ihnen gezielt Informationen entnehmen.';
$string['schule_re_b1_4'] = 'Ich kann den Gedanken und Argumenten in einem Text folgen, ohne diesen in allen Einzelheiten zu verstehen.';
$string['schule_re_b1_5'] = 'Ich kann den Sinn von Geschichten, Theaterstücken, Gedichten, Liedtexten usw. erfassen.';
$string['schule_re_b2_1'] = 'Ich kann private Korrespondenz und Standardbriefe von Behörden und Unternehmen verstehen.';
$string['schule_re_b2_2'] = 'Ich kann langen, auch schwierigeren Texten beim raschen Überfliegen die wichtigsten Informationen entnehmen und entscheiden, ob sich genaues Lesen für meine Zwecke lohnt.';
$string['schule_re_b2_3'] = 'Ich kann beim Lesen auch umfangreicherer Texte den dargelegten Gedanken folgen und Standpunkte ermitteln.';
$string['schule_re_b2_4'] = 'Ich kann zeitgenössische literarische Texte lesen und dabei der Gesamtaussage und bestimmten Aspekten im Einzelnen nachgehen (z.B. Handlungsverlauf, Charakter von Personen, Atmosphäre und Stimmungen).';
$string['schule_re_c1_1'] = 'Ich kann unter gelegentlicher Zuhilfenahme eines Wörterbuchs jede Art von Korrespondenz verstehen.';
$string['schule_re_c1_2'] = 'Ich kann sprachlich anspruchsvolle längere Texte im Wesentlichen verstehen, wenn ich bei besonders schwierigen Abschnitten Hilfsmittel (Wörterbuch, Suchmaschine usw.) verwende';
$string['schule_re_c1_3'] = 'Ich kann längere komplexe Anleitungen und Anweisungen verstehen, z. B. zur Bedienung eines neuen Geräts, auch wenn diese nicht in Bezug zu meinem Sach- oder Interessensgebiet stehen.';
$string['schule_re_c1_4'] = 'Ich kann in längeren Analysen, Berichten und Kommentaren Meinungen, Standpunkte und Zusammenhänge erfassen.';
$string['schule_re_c1_5'] = 'Ich kann literarische und journalistische Texte gut verstehen und Unterschiede in Stil und Ausdruck wahrnehmen.';
$string['schule_re_c2_1'] = 'Ich kann Texte verstehen, die stark von der Standardsprache abweichen.';
$string['schule_re_c2_2'] = 'Ich kann Handbücher, Verordnungen und Verträge verstehen, auch wenn mir das Gebiet nicht vertraut ist.';
$string['schule_re_c2_3'] = 'Ich kann zeitgenössische und klassische literarische Texte verschiedener Gattungen lesen (Gedichte, Prosa, dramatische Werke).';
$string['schule_re_c2_4'] = 'Ich kann Wortspiele erkennen und Texte richtig verstehen, deren eigentliche Bedeutung nicht in dem liegt, was vordergründig gesagt wird (z. B. Ironie, Satire).';
$string['schule_wr_a1_1'] = 'Ich kann kurze Texte über mich und andere Personen schreiben.';
$string['schule_wr_a1_2'] = 'Ich kann über mein Zuhause, meinen Schulalltag und meine Freizeit schreiben.';
$string['schule_wr_a1_3'] = 'Ich kann Notizen und Mitteilungen an Freunde schreiben.';
$string['schule_wr_a1_4'] = 'Ich kann Fragen stellen (z.B. in einem Brief oder einer E-Mail) und Fragen schriftlich beantworten.';
$string['schule_wr_a2_1'] = 'Ich kann Texte über meine Familie, meine Interessen, die Schule oder Freizeitaktivitäten schreiben.';
$string['schule_wr_a2_2'] = 'Ich kann Orte, Gegenstände und Personen aus meiner Umgebung in einem kurzen Text beschreiben.';
$string['schule_wr_a2_3'] = 'Ich kann eine kurze Notiz oder Mitteilung schreiben, um jemanden zu informieren, z.B. wo ich bin oder wo wir uns treffen.';
$string['schule_wr_a2_4'] = 'Ich kann kurze Briefe, Postkarten, E-Mails oder SMS schreiben, in denen ich mich auch bedanken oder entschuldigen kann.';
$string['schule_wr_a2_5'] = 'Ich kann einfache kürzere Texte über Erlebtes, Gelesenes oder Erfundenes schreiben.';
$string['schule_wr_b1_1'] = 'Ich kann schriftlich darstellen, was ich getan und erlebt habe und wie ich mich dabei gefühlt habe.';
$string['schule_wr_b1_2'] = 'Ich kann meine Meinung, Gefühle und Anteilnahme ausdrücken, z.B. in Briefen und E-Mails.';
$string['schule_wr_b1_3'] = 'Ich kann mit Hilfe einer Vorlage einfache formelle Schreiben verfassen, z.B. einen Lebenslauf, ein Bewerbungsschreiben oder einen Geschäftsbrief.';
$string['schule_wr_b1_4'] = 'Ich kann gezielt Informationen aus Gehörtem und Gelesenem in Notizen festhalten.';
$string['schule_wr_b1_5'] = 'Ich kann einfache Sachinformationen schriftlich mitteilen oder danach fragen.';
$string['schule_wr_b1_6'] = 'Ich kann den Handlungsverlauf von gelesenen oder gehörten Texten schriftlich wiedergeben.';
$string['schule_wr_b1_7'] = 'Ich kann über verschiedene Themen einen Text schreiben und darin persönliche Ansichten und Meinungen, Gefühle und Stimmungen ausdrücken.';
$string['schule_wr_b2_1'] = 'Ich kann gegliedert und anschaulich beschreiben, was ich erlebt, erfahren oder mir ausgedacht habe.';
$string['schule_wr_b2_2'] = 'Ich kann private Briefe und E-Mails zu Themen des täglichen Lebens schreiben und dabei auf die Erzählungen, Berichte, Gefühle, Standpunkte meiner Partnerinnen und Partner eingehen.';
$string['schule_wr_b2_3'] = 'Ich kann formelle und halbformelle Briefe schreiben, z.B. ein Bewerbungsschreiben, eine Anfrage oder einen Leserbrief.';
$string['schule_wr_b2_4'] = 'Ich kann Informationen aus verschiedenen Quellen und Medien schriftlich zusammenfassen und verständlich präsentieren.';
$string['schule_wr_b2_5'] = 'Ich kann den Inhalt von Filmen und Büchern oder Gesprächen klar und sachgerecht wiedergeben und Erlebtes oder Beobachtetes genau zusammenfassen.';
$string['schule_wr_b2_6'] = 'Ich kann ein Thema erörtern und dabei Gründe für oder gegen einen bestimmten Standpunkt darlegen sowie Vor- und Nachteile erläutern.';
$string['schule_wr_b2_7'] = 'Ich kann mit Hilfe von Mustern einfache Texte literarischer Genres schreiben.';
$string['schule_wr_c1_1'] = 'Ich kann eigene Erlebnisse und Erfahrungen klar, verständlich und lebendig wiedergeben.';
$string['schule_wr_c1_2'] = 'Ich kann private und formelle Briefe im jeweils angemessenen Ton abfassen.';
$string['schule_wr_c1_3'] = 'Ich kann zu einem Ereignis oder Sachverhalt Stellung nehmen, Standpunkte darstellen und erörtern und meine Position begründet und nachvollziehbar darstellen.';
$string['schule_wr_c1_4'] = 'Ich kann literarische Texte, Dramen und Filme zusammenfassen, untersuchen und begründet darlegen, wie ich sie aus meiner Sicht deute.';
$string['schule_wr_c2_1'] = 'Ich kann ohne Mühe anspruchsvolle private und formelle Briefe schreiben.';
$string['schule_wr_c2_2'] = 'Ich kann gut strukturierte Berichte, Artikel und Stellungnahmen verfassen.';
$string['schule_wr_c2_3'] = 'Ich kann Zusammenfassungen und Besprechungen von Fachliteratur und künstlerischen Werken schreiben.';
$string['schule_sp_a1_1'] = 'Ich kann etwas über meine Familie, meine Freunde und Freundinnen erzählen.';
$string['schule_sp_a1_2'] = 'Ich kann über mich, meinen Schulalltag und meine Freizeit sprechen.';
$string['schule_sp_a2_1'] = 'Ich kann in zusammenhängenden Sätzen über mich, meine Familie und meine Freunde und Freundinnen berichten.';
$string['schule_sp_a2_2'] = 'Ich kann über meinen Tagesablauf berichten.';
$string['schule_sp_a2_3'] = 'Ich kann über meine Hobbys und Interessen berichten und Vorlieben und Abneigungen äußern.';
$string['schule_sp_a2_4'] = 'Ich kann über ein Ereignis oder ein Erlebnis in kurzen, einfachen Sätzen berichten.';
$string['schule_sp_a2_5'] = 'Ich kann Alltagsthemen kurz, einfach und zusammenhängend präsentieren, wenn ich mich darauf vorbereitet habe.';
$string['schule_sp_a2_6'] = 'Ich kann kurze gelesene oder gehörte Texte mit einfachen Worten wiedergeben.';
$string['schule_sp_a2_7'] = 'Ich kann mit Hilfe vorgegebener Wörter oder Bilder einfache Geschichten erzählen, wenn ich mich darauf vorbereitet habe.';
$string['schule_sp_b1_1'] = 'Ich kann erzählen oder berichten, was ich erlebt, beobachtet oder unternommen habe.';
$string['schule_sp_b1_2'] = 'Ich kann über Musik, Filme, Bücher und Fernsehsendungen sprechen und meine Meinung dazu sagen.';
$string['schule_sp_b1_3'] = 'Ich kann meine Absichten, Pläne und Ziele darlegen und begründen.';
$string['schule_sp_b1_4'] = 'Ich kann Informationen wiedergeben, die ich gehört oder gelesen habe.';
$string['schule_sp_b1_5'] = 'Ich kann gut vorbereitete Kurzpräsentationen durchführen und durch meine Darstellung das Zuhören leicht und interessant machen.';
$string['schule_sp_b1_6'] = 'Ich kann mit Hilfe von Stichwörtern oder Bildern Geschichten erzählen.';
$string['schule_sp_b2_1'] = 'Ich kann spontan erzählen und berichten, was ich erlebt, erfahren, mir ausgedacht habe oder was ich vorhabe.';
$string['schule_sp_b2_2'] = 'Ich kann die Handlung und Abfolge von Ereignissen in Büchern, Filmen, Fernsehsendungen, Theaterstücken usw. zusammenfassen.';
$string['schule_sp_b2_3'] = 'Ich kann längere Texte und kurze Auszüge aus Nachrichten, Interviews, Reportagen usw., die Stellungnahmen und Diskussionen enthalten, zusammenfassen.';
$string['schule_sp_b2_4'] = 'Ich kann meinen Standpunkt ausführlich und klar gegliedert darstellen und begründen, durch geeignete Beispiele stützen und Vor- und Nachteile sowie Alternativen aufzeigen.';
$string['schule_sp_b2_5'] = 'Ich kann zu vielen Themen meines Interesses detaillierte Beschreibungen und Berichte geben.';
$string['schule_sp_b2_6'] = 'Ich kann Abläufe beschreiben und komplexere Arbeitsanleitungen und Anweisungen geben.';
$string['schule_sp_b2_7'] = 'Ich kann mit Hilfe weniger Stichwörter Geschichten erzählen.';
$string['schule_sp_c1_1'] = 'Ich kann fließend in allen Einzelheiten über meine Erlebnisse, Ideen und Pläne berichten.';
$string['schule_sp_c1_2'] = 'Ich kann lange, anspruchsvolle Texte mündlich zusammenfassen und wichtige Einzelheiten dabei genau wiedergeben.';
$string['schule_sp_c1_3'] = 'Ich kann komplexe Sachverhalte klar und detailliert darstellen.';
$string['schule_sp_c1_4'] = 'Ich kann mündlich etwas ausführlich darstellen oder berichten, dabei inhaltliche Aspekte zueinander in Bezug setzen, bestimmte Gesichtspunkte genauer ausführen und den Beitrag angemessen abschließen.';
$string['schule_sp_c1_5'] = 'Ich kann in meinem Fach- und Interessensgebiet einen klar gegliederten Vortrag halten, dabei, wenn nötig, vom vorbereiteten Text abweichen und spontan auf Fragen von Zuhörerinnen und Zuhörern reagieren.';
$string['schule_sp_c1_6'] = 'Ich kann Geschichten interessant und lebendig erzählen.';
$string['schule_sp_c2_1'] = 'Ich kann mühelos und detailliert meine Erfahrungen, Erlebnisse, Ideen und Pläne darstellen und dabei auch feinere Bedeutungsnuancen genau zum Ausdruck bringen.';
$string['schule_sp_c2_2'] = 'Ich kann Informationen aus verschiedenen Quellen mündlich zusammenfassen und die dabei enthaltenen Argumente und Sachverhalte in einer klaren, zusammenhängenden Darstellung wiedergeben.';
$string['schule_sp_c2_3'] = 'Ich kann Gedanken und Standpunkte sehr flexibel vortragen und mich auch zu abstrakten, schwierigen Themen spontan und flüssig äußern.';
$string['schule_sp_c2_4'] = 'Ich kann ein komplexes Thema sprachlich und inhaltlich gut strukturiert präsentieren. Dabei erleichtere ich meinen Zuhörerinnen und Zuhörern das Verständnis, indem ich meine Ausführungen logisch aufbaue und auf wichtige Aspekte gezielt verweise.';
$string['schule_sp_c2_5'] = 'Ich kann mühelos Geschichten frei erzählen und sie interessant und lebendig darstellen.';
$string['schule_si_a1_1'] = 'Ich kann jemanden begrüßen und verabschieden, und ich kann etwas über mich erzählen.';
$string['schule_si_a1_2'] = 'Ich kann einem aneren Menschen Fragen stellen, um ihn besser kennen zu lernen. Ich auch wiedergeben, was er über sich sagt.';
$string['schule_si_a1_3'] = 'Ich weiß, was ich sagen kann, wenn ich andere Menschen im Alltag und zu Festtagen treffe.';
$string['schule_si_a1_4'] = 'Ich kann Fragen über den Tages- und Jahresablauf stellen und beantworten.';
$string['schule_si_a1_5'] = 'Ich kann mich beim Einkauf verständigen.';
$string['schule_si_a1_6'] = 'Ich kann sagen, wo sich etwas befindet.';
$string['schule_si_a1_7'] = 'Ich kann um etwas bitten.';
$string['schule_si_a1_8'] = 'Ich kann sagen, dass ich etwas nicht verstanden habe.';
$string['schule_si_a2_1'] = 'Ich kann mich mit anderen über mich, meine Familie, Schule und Freizeit unterhalten.';
$string['schule_si_a2_2'] = 'Ich kann in einfachen Worten meine Meinung zu einem bestimmten Thema äußern.';
$string['schule_si_a2_3'] = 'Ich kann mich mit anderen verabreden, andere einladen und auf Einladungen reagieren.';
$string['schule_si_a2_4'] = 'Ich kann sagen, ob ich mit etwas einverstanden bin oder nicht, und auch eigene Vorschläge machen.';
$string['schule_si_a2_5'] = 'Ich kann mich an Kiosken, in Geschäften und in einem Restaurant darüber verständigen, was ich haben oder wissen möchte.';
$string['schule_si_a2_6'] = 'Ich kann am Schalter (z.B. Post, Bank, Flughafen, Bahnhof) einfache Informationen erfragen.';
$string['schule_si_a2_7'] = 'Ich kann Auskünfte über Ort, Zeit und Weg erfragen und geben.';
$string['schule_si_b1_1'] = 'Ich kann viele Alltagssituationen sprachlich bewältigen, z.B. Erkundigungen einholen, Verabredungen treffen oder ein Problem schildern.';
$string['schule_si_b1_2'] = 'Ich kann Gespräche über Themen führen, die mich interessieren und über die ich etwas weiß.';
$string['schule_si_b1_3'] = 'Ich kann in einer Diskussion zu Themen, mit denen ich mich beschäftigt habe, persönliche Ansichten äußern und Meinungen austauschen.';
$string['schule_si_b1_4'] = 'Ich kann meine Meinung äußern und begründen, ich kann zustimmen, höflich widersprechen und Gegenvorschläge einbringen.';
$string['schule_si_b1_5'] = 'Ich kann Gefühle wie Überraschung, Freude, Trauer, Interesse und Gleichgültigkeit mit einigen wenigen Redewendungen ausdrücken. Ich kann auch auf entsprechende Gefühlsäußerungen anderer reagieren.';
$string['schule_si_b2_1'] = 'Ich kann spontan ein Gespräch über ein Thema von allgemeinem Interesse, auch mit Muttersprachlerinnen und Muttersprachlern, beginnen, aufrechterhalten und beenden.';
$string['schule_si_b2_2'] = 'Ich kann in Diskussionen meinen Standpunkt vertreten und auf Gegenargumente im Einzelnen eingehen, wenn es sich um Sachverhalte handelt, die ich kenne.';
$string['schule_si_b2_3'] = 'Ich kann in Gesprächen und Diskussionen Absichten, Wünsche, Einwände, Bedenken und Gegenvorschläge höflich vorbringen. Dabei kann ich begründen, warum ich mit etwas nicht einverstanden bin oder mich missverstanden fühle, und ich kann über eine Regelung oder Lösung verhandeln.';
$string['schule_si_b2_4'] = 'Ich kann meine Gefühle ausdrücken und hervorheben, was für mich persönlich an Ereignissen und Erfahrungen bedeutsam ist.';
$string['schule_si_c1_1'] = 'Ich kann auch in lebhaften Gesprächen mit Muttersprachlerinnen und Muttersprachlern gut mithalten, selbst wenn Themen besprochen werden, die mir weniger vertraut sind.';
$string['schule_si_c1_2'] = 'Ich kann meine Gedanken und Meinungen präzise und klar ausdrücken, meine eigenen Beiträge auf die anderer Gesprächsteilnehmer beziehen und Ergebnisse zusammenfassen und erläutern.';
$string['schule_si_c1_3'] = 'Ich kann überzeugend eine Position vertreten, Fragen und Kommentare beantworten und auch auf umfangreiche Gegenargumente spontan und flexibel reagieren.';
$string['schule_si_c1_4'] = 'Ich kann mich über meine Gefühle und Erfahrungen treffend und situationsgerecht äußern und in unterschiedlichen Situationen auf die Empfindungen und Gedanken verschiedener Gesprächspartner angemessen reagieren.';
$string['schule_si_c2_1'] = 'Ich kann sprachliche Situationen jeglicher Art sicher bewältigen.';
$string['schule_si_c2_2'] = 'Ich kann mich mühelos an allen Gesprächen und Diskussionen mit Muttersprachlerinnen und Muttersprachlern beteiligen.';
$string['schule_si_c2_3'] = 'Ich kann in Diskussionen und Gesprächen mühelos meinen Standpunkt vertreten und dabei jederzeit auf umfangreiche Fragen, Argumente und Einwände anderer flexibel und wirkungsvoll reagieren. Dabei kann ich auch vielschichtige Überlegungen und Haltungen präzise und deutlich formulieren und sehr umfangreiche Ergebnisse bündig zusammenfassen und erläutern.';
$string['schule_si_c2_4'] = 'Ich kann meine Gefühle und Erfahrungen so darstellen, dass auch feinere Bedeutungsnuancen deutlich werden und kann mich mühelos und situationsgerecht auf die Empfindungen und Gedanken verschiedener Gesprächspartner einstellen.';


?>
