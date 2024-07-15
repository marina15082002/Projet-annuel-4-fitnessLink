from difflib import SequenceMatcher

sport_professionals = [
    {'name': 'Sophia Thompson', 'gender': 'femme', 'specialties': ['musculation', 'cardio', 'entraînement en circuit']},
    {'name': 'Liam Rodriguez', 'gender': 'homme', 'specialties': ['nage libre', 'brasse', 'papillon', 'dos crawlé']},
    {'name': 'Emma Williams', 'gender': 'femme', 'specialties': ['hatha yoga', 'vinyasa yoga', 'ashtanga yoga', 'yoga prénatal']},
    {'name': 'Noah Nguyen', 'gender': 'homme', 'specialties': ['boxe anglaise', 'boxe française', 'boxe thaïlandaise', 'kickboxing']},
    {'name': 'Olivia Patel', 'gender': 'femme', 'specialties': ['course sur route', 'course en montagne', 'course de fond', 'course de vitesse']},
    {'name': 'John Doe', 'gender': 'homme', 'specialties': ['musculation', 'crossfit', 'powerlifting']},
    {'name': 'Jane Smith', 'gender': 'femme', 'specialties': ['musculation', 'yoga', 'pilates']},
    {'name': 'Michael Brown', 'gender': 'homme', 'specialties': ['natation', 'triathlon', 'water-polo']},
    {'name': 'Emily Davis', 'gender': 'femme', 'specialties': ['natation synchronisée', 'plongée', 'aquagym']},
]

def ask_question(question):
    print(question)
    response = input("> ").strip().lower()
    return response

def correct_gender(gender):
    gender_lower = gender.lower()
    for pro_gender in ['homme', 'femme']:
        similarity_ratio = SequenceMatcher(None, gender_lower, pro_gender).ratio()
        if similarity_ratio > 0.7:
            return pro_gender
    return gender

def correct_specialties(specialty, specialties_list):
    for correct_specialty in specialties_list:
        if specialty in correct_specialty:
            return correct_specialty
    return specialty

def main():
    preferred_gender = ask_question("Préférez-vous être entraîné par un homme ou une femme ?")
    user_specialties = ask_question("Quelles sont vos spécialités sportives préférées ? (par exemple : musculation, yoga, natation)").split(' ')

    preferred_gender = correct_gender(preferred_gender)

    recommended_professionals = []
    for pro in sport_professionals:
        if pro['gender'] == preferred_gender:
            for specialty in user_specialties:
                specialty = specialty.strip().lower()
                corrected_specialty = correct_specialties(specialty, pro['specialties'])
                if corrected_specialty in pro['specialties']:
                    recommended_professionals.append(pro['name'])
                    break

    if recommended_professionals:
        print("Nous vous recommandons de consulter les professionnels suivants :")
        for pro in recommended_professionals:
            print("- " + pro)
    else:
        print("Désolé, aucun professionnel ne correspond à vos critères pour le moment.")

if __name__ == "__main__":
    main()