import sys
import json
import pandas as pd

def filter_data(df, improve_skill=False, losing_weight=False, available_week=False, budget=None, describe_coach=None, interesting_activity=None):
    filtered_df = df[df['Role'] == 2]  # Filtrer par rôle 2
    profession = 'Entraîneur'

    # Filtrer par compétence à améliorer
    if improve_skill:
        filtered_df = filtered_df[filtered_df['Profession'].str.contains(profession, case=False, na=False)]

    # Filtrer par perte de poids
    if losing_weight:
        filtered_df = filtered_df[filtered_df['Profession'].str.contains(profession, case=False, na=False)]

    # Filtrer par disponibilité hebdomadaire
    if available_week:
        filtered_df = filtered_df[filtered_df['Profession'].str.contains(profession, case=False, na=False)]

    # Filtrer par budget
    if budget:
        filtered_df = filtered_df[filtered_df['Profession'].str.contains(profession, case=False, na=False)]

    return filtered_df.head(5)

def main():
    json_file = 'src/assets/database/chatbot_input.json'

    # Lecture du fichier JSON
    with open(json_file, 'r') as file:
        data = json.load(file)

    # Utilisation des données
    print("inputImproveSkill:", data["inputImproveSkill"])
    print("inputLosingWeight:", data["inputLosingWeight"])
    print("inputAvailableWeek:", data["inputAvailableWeek"])
    print("inputBudget:", data["inputBudget"])
    #print("inputDescribeSportCoach:", data["inputDescribeSportCoach"])
    #print("inputInterresantSportingActivity:", data["inputInterresantSportingActivity"])

    # Lire les données du CSV
    try:
        df = pd.read_csv('src/assets/database/database_users.csv')
    except FileNotFoundError:
        print("Fichier CSV introuvable.")
        sys.exit(1)

    # Extraire les données des champs d'entrée
    improve_skill = data.get('inputImproveSkill') == "Oui"
    losing_weight = data.get('inputLosingWeight') == "Oui"
    available_week = data.get('inputAvailableWeek') == "Oui"
    budget = data.get('inputBudget')

    # Filtrer les données
    filtered_df = filter_data(df, improve_skill, losing_weight, available_week, budget)

    # Convertir les résultats en JSON
    filtered_df.to_csv('src/assets/database/chatbot_output.csv', index=False)

if __name__ == "__main__":
    main()