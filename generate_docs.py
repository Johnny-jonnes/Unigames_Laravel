import os
from docx import Document
from docx.shared import Pt, RGBColor, Inches
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.oxml.ns import qn

# --- CONFIGURATION DU STYLE ---
def setup_document(doc):
    # Style Normal
    style = doc.styles['Normal']
    font = style.font
    font.name = 'Calibri'
    font.size = Pt(11)
    
    # Styles des Titres
    colors = {
        'Heading 1': RGBColor(26, 75, 173), # Bleu Entreprise (#1A4BAD)
        'Heading 2': RGBColor(40, 90, 190),
        'Heading 3': RGBColor(80, 80, 80)
    }
    
    for heading, color in colors.items():
        if heading in doc.styles:
            h_style = doc.styles[heading]
            h_font = h_style.font
            h_font.name = 'Calibri'
            h_font.color.rgb = color
            h_font.bold = True

def add_cover_page(doc, title, subtitle, version="1.0"):
    doc.add_paragraph('\n' * 5)
    
    p_title = doc.add_paragraph()
    p_title.alignment = WD_ALIGN_PARAGRAPH.CENTER
    run_title = p_title.add_run(title)
    run_title.font.size = Pt(36)
    run_title.font.bold = True
    run_title.font.color.rgb = RGBColor(26, 75, 173)

    p_sub = doc.add_paragraph()
    p_sub.alignment = WD_ALIGN_PARAGRAPH.CENTER
    run_sub = p_sub.add_run(subtitle)
    run_sub.font.size = Pt(18)
    run_sub.font.color.rgb = RGBColor(100, 100, 100)
    
    doc.add_paragraph('\n' * 15)
    
    p_info = doc.add_paragraph()
    p_info.alignment = WD_ALIGN_PARAGRAPH.RIGHT
    run_info = p_info.add_run(f"Projet : UniGames\nDate : Juin 2026\nVersion : {version}")
    run_info.font.size = Pt(12)
    run_info.font.color.rgb = RGBColor(80, 80, 80)
    
    doc.add_page_break()

def create_cahier_des_charges():
    doc = Document()
    setup_document(doc)
    add_cover_page(doc, "Cahier des Charges", "Spécifications des besoins du projet UniGames")
    
    doc.add_heading("1. Présentation du Projet", level=1)
    doc.add_paragraph("Le projet UniGames est une plateforme web développée en Laravel, dédiée à la gestion complète de compétitions sportives inter-universitaires.")
    doc.add_paragraph("Objectif principal : Digitaliser et simplifier l'organisation des tournois, la gestion des équipes, l'enregistrement des scores et la consultation des classements.")
    
    doc.add_heading("2. Périmètre Fonctionnel", level=1)
    p = doc.add_paragraph("Le système couvre les domaines suivants :")
    doc.add_paragraph("Gestion des Éditions (Tournois annuels)", style='List Bullet')
    doc.add_paragraph("Gestion des Facultés et Universités participantes", style='List Bullet')
    doc.add_paragraph("Gestion des Disciplines Sportives", style='List Bullet')
    doc.add_paragraph("Gestion des Équipes et de leurs Joueurs", style='List Bullet')
    doc.add_paragraph("Gestion du Calendrier des Matchs et Saisie des Scores", style='List Bullet')
    doc.add_paragraph("Génération Automatique des Classements et de l'Arbre du Tournoi", style='List Bullet')
    
    doc.add_heading("3. Acteurs et Droits", level=1)
    doc.add_paragraph("Administrateur : Accès total. Peut créer, modifier, supprimer toutes les entités.", style='List Bullet')
    doc.add_paragraph("Staff : Accès en lecture et modification (saisie des scores), mais ne peut pas supprimer d'entités majeures.", style='List Bullet')
    doc.add_paragraph("Visiteur : Accès en lecture seule aux tableaux de bord, classements et plannings.", style='List Bullet')
    
    doc.save("docs/1_Cahier_des_Charges.docx")

def create_manuel_utilisateur():
    doc = Document()
    setup_document(doc)
    add_cover_page(doc, "Manuel Utilisateur", "Guide d'utilisation de la plateforme UniGames")
    
    doc.add_heading("1. Introduction", level=1)
    doc.add_paragraph("Bienvenue sur la plateforme UniGames. Ce manuel vous guidera à travers les fonctionnalités principales de l'application.")
    
    doc.add_heading("2. Connexion et Tableau de Bord", level=1)
    doc.add_paragraph("Une fois connecté via l'URL principale, vous arrivez sur le Tableau de Bord. Ce dernier affiche les indicateurs clés : nombre de facultés, équipes inscrites, matchs joués et joueurs enregistrés.")
    doc.add_paragraph("Sélection de l'édition : En haut à droite, une liste déroulante permet de basculer entre les différentes éditions du tournoi (ex: Édition 2026).")
    
    doc.add_heading("3. Gestion des Matchs et Saisie des Scores", level=1)
    doc.add_paragraph("Pour saisir un score :")
    doc.add_paragraph("Allez dans le menu 'Matchs'.", style='List Number')
    doc.add_paragraph("Cliquez sur le bouton 'Voir' d'un match planifié.", style='List Number')
    doc.add_paragraph("Remplissez le formulaire 'Saisie du Score et des Buteurs' en indiquant le score et en sélectionnant les joueurs ayant marqué.", style='List Number')
    doc.add_paragraph("Cliquez sur 'Enregistrer'.", style='List Number')
    
    doc.add_heading("4. Consultation de l'Arbre du Tournoi", level=1)
    doc.add_paragraph("Depuis la page 'Éditions', en cliquant sur 'Arbre du Tournoi', vous visualiserez un diagramme interactif montrant l'avancement des phases finales (Quarts, Demies, Finale).")
    
    doc.save("docs/2_Manuel_Utilisateur.docx")

def create_dossier_architecture():
    doc = Document()
    setup_document(doc)
    add_cover_page(doc, "Dossier d'Architecture", "Architecture Technique et Base de Données")
    
    doc.add_heading("1. Choix Technologiques", level=1)
    doc.add_paragraph("Framework Backend : Laravel (PHP 8.4)")
    doc.add_paragraph("Base de Données : MySQL")
    doc.add_paragraph("Frontend : Blade Templating, Alpine.js (pour la réactivité côté client), et Tailwind CSS (pour le design)")
    
    doc.add_heading("2. Modèle de Données (MCD)", level=1)
    doc.add_paragraph("Le modèle relationnel s'articule autour des tables suivantes :")
    doc.add_paragraph("users : Authentification et rôles (admin, staff).", style='List Bullet')
    doc.add_paragraph("editions : Représente une compétition (ex: 2026).", style='List Bullet')
    doc.add_paragraph("facultes : Les établissements participants.", style='List Bullet')
    doc.add_paragraph("disciplines : Les sports (Football, Basketball...).", style='List Bullet')
    doc.add_paragraph("equipes : Liées à une édition, une faculté et une discipline.", style='List Bullet')
    doc.add_paragraph("joueurs : Membres d'une équipe, avec suivi des buts marqués.", style='List Bullet')
    doc.add_paragraph("matchs : Oppose deux équipes (equipe_a_id, equipe_b_id), stocke le score, la date et la phase.", style='List Bullet')
    
    doc.save("docs/3_Dossier_Architecture.docx")

def create_specifications():
    doc = Document()
    setup_document(doc)
    add_cover_page(doc, "Spécifications Fonctionnelles", "Règles de gestion et parcours utilisateurs")
    
    doc.add_heading("1. Règles de Gestion (RG)", level=1)
    doc.add_paragraph("RG01 - Unicité Équipe : Une faculté ne peut inscrire qu'une seule équipe par discipline et par édition.")
    doc.add_paragraph("RG02 - Statut d'Édition : Une édition peut être 'A venir', 'En cours' ou 'Terminée'. Les saisies de score de masse peuvent modifier le statut.")
    doc.add_paragraph("RG03 - Buteurs : Lors de la saisie d'un score, le total des buts attribués aux joueurs ne peut excéder le score de l'équipe.")
    
    doc.add_heading("2. Parcours 'Programmer un Match'", level=1)
    doc.add_paragraph("1. L'administrateur accède au formulaire de création de match.")
    doc.add_paragraph("2. Il choisit l'édition et la discipline.")
    doc.add_paragraph("3. Il sélectionne deux équipes différentes appartenant à cette même discipline et édition.")
    doc.add_paragraph("4. Il définit la date, le lieu et la phase (ex: Poule A, Demi-Finale).")
    
    doc.save("docs/4_Specifications_Fonctionnelles.docx")

def create_installation():
    doc = Document()
    setup_document(doc)
    add_cover_page(doc, "Guide de Déploiement", "Procédure d'installation de l'environnement")
    
    doc.add_heading("1. Prérequis", level=1)
    doc.add_paragraph("PHP >= 8.2", style='List Bullet')
    doc.add_paragraph("Composer 2.x", style='List Bullet')
    doc.add_paragraph("MySQL 8.0+", style='List Bullet')
    doc.add_paragraph("Node.js & NPM", style='List Bullet')
    
    doc.add_heading("2. Installation locale", level=1)
    doc.add_paragraph("1. Cloner le dépôt : git clone [url]", style='List Number')
    doc.add_paragraph("2. Installer les dépendances PHP : composer install", style='List Number')
    doc.add_paragraph("3. Installer les dépendances JS : npm install", style='List Number')
    doc.add_paragraph("4. Copier le fichier d'environnement : cp .env.example .env", style='List Number')
    doc.add_paragraph("5. Générer la clé d'application : php artisan key:generate", style='List Number')
    doc.add_paragraph("6. Configurer la base de données dans le fichier .env", style='List Number')
    doc.add_paragraph("7. Lancer les migrations et les seeders : php artisan migrate --seed", style='List Number')
    doc.add_paragraph("8. Lancer les serveurs : php artisan serve et npm run dev", style='List Number')
    
    doc.save("docs/5_Guide_Installation.docx")

def create_plan_test():
    doc = Document()
    setup_document(doc)
    add_cover_page(doc, "Plan de Tests", "Cahier de Recette et Validation")
    
    doc.add_heading("1. Stratégie de Test", level=1)
    doc.add_paragraph("Les tests couvrent les fonctionnalités critiques de la plateforme (CRUD, Authentification, Saisie des scores).")
    
    doc.add_heading("2. Scénarios de Test", level=1)
    doc.add_paragraph("Cas de test 01 : Authentification Admin")
    doc.add_paragraph("- Action : Se connecter avec admin@unigames.com / password\n- Résultat attendu : Redirection vers le dashboard, tous les menus sont accessibles.\n- Statut : VALIDE", style='List Bullet')
    
    doc.add_paragraph("Cas de test 02 : Création de Joueur avec protection de routage")
    doc.add_paragraph("- Action : Se connecter en Staff et tenter de supprimer un joueur.\n- Résultat attendu : Le bouton supprimer est invisible, accès direct par URL refusé (Middleware).\n- Statut : VALIDE", style='List Bullet')
    
    doc.add_paragraph("Cas de test 03 : Calcul du Classement")
    doc.add_paragraph("- Action : Saisir un score de 2-1 pour l'Equipe A.\n- Résultat attendu : L'Equipe A reçoit 3 points, l'Equipe B 0 point. Le classement est mis à jour.\n- Statut : VALIDE", style='List Bullet')
    
    doc.save("docs/6_Plan_Tests.docx")

def create_maquette():
    doc = Document()
    setup_document(doc)
    add_cover_page(doc, "Dossier de Maquettage", "Interfaces et Parcours Visuel")
    
    doc.add_heading("1. Design System", level=1)
    doc.add_paragraph("Couleur Principale : Bleu (#1A4BAD) - Représente l'institution et la confiance.")
    doc.add_paragraph("Couleur Secondaire : Vert Emeraude (#10B981) - Utilisé pour les actions de validation et les scores positifs.")
    doc.add_paragraph("Typographie : Polices système (Inter/Roboto) avec classes utilitaires Tailwind.")
    
    doc.add_heading("2. Structure des pages", level=1)
    doc.add_paragraph("Toutes les pages partagent un Layout commun (x-app-layout) :")
    doc.add_paragraph("Sidebar : Navigation principale (Dashboard, Editions, Facultés, Equipes...).", style='List Bullet')
    doc.add_paragraph("Header : Titre de la page, actions contextuelles (ex: Programmer un match).", style='List Bullet')
    doc.add_paragraph("Contenu : Grilles de cartes (enterprise-card) avec effets de survol et design 'glassmorphism' subtil.", style='List Bullet')
    
    doc.add_heading("3. Intégration des captures", level=1)
    doc.add_paragraph("Note: Les captures d'écran des fonctionnalités en situation réelle sont disponibles dans les annexes du repository. La structure des tableaux inclut systématiquement un champ de recherche en temps réel développé avec Alpine.js.")
    
    doc.save("docs/7_Dossier_Maquettage.docx")

def main():
    if not os.path.exists('docs'):
        os.makedirs('docs')
        
    print("Génération du Cahier des Charges...")
    create_cahier_des_charges()
    print("Génération du Manuel Utilisateur...")
    create_manuel_utilisateur()
    print("Génération du Dossier d'Architecture...")
    create_dossier_architecture()
    print("Génération des Spécifications...")
    create_specifications()
    print("Génération du Guide d'Installation...")
    create_installation()
    print("Génération du Plan de Tests...")
    create_plan_test()
    print("Génération du Dossier de Maquettage...")
    create_maquette()
    print("Terminé ! Les 7 documents sont dans le dossier 'docs'.")

if __name__ == "__main__":
    main()
