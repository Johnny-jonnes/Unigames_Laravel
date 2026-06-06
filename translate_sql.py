import os
import re

sql_file = "docs/unigames_database.sql"

if not os.path.exists(sql_file):
    print(f"Error: {sql_file} not found.")
    exit(1)

with open(sql_file, 'r', encoding='utf-8') as f:
    content = f.read()

# Translations
replacements = {
    r"-- Table structure for table": "-- Structure de la table",
    r"-- Dumping data for table": "-- Déchargement des données de la table",
    r"-- Host:": "-- Hôte :",
    r"    Database:": "    Base de données :",
    r"-- Server version": "-- Version du serveur",
    r"-- Dumping events for database": "-- Déchargement des évènements de la base de données",
    r"-- Dumping routines for database": "-- Déchargement des routines de la base de données",
    r"-- Dump completed on": "-- Dump terminé le"
}

for eng, fra in replacements.items():
    content = re.sub(eng, fra, content)

with open(sql_file, 'w', encoding='utf-8') as f:
    f.write(content)

print("Translation completed successfully!")
