import pandas as pd

df = pd.read_csv('database_users.csv')


def filter_data(age_range=None, profession=None, specialties=None):
    filtered_df = df[df['Role'] == 2]  # Filtrer par rôle 2

    if age_range:
        age_min, age_max = age_range
        filtered_df = filtered_df[(filtered_df['Age'] >= age_min) & (filtered_df['Age'] <= age_max)]

    if profession:
        filtered_df = filtered_df[filtered_df['Profession'].str.contains(profession, case=False, na=False)]

    if specialties:
        filtered_df = filtered_df[filtered_df['Specialties'].str.contains(specialties, case=False, na=False)]

    return filtered_df.head(5)


def get_user_input():
    print("Veuillez sélectionner vos critères de filtre.")

    age_choice = input("Voulez-vous filtrer par âge? (oui/non) ").lower()
    if age_choice == 'oui':
        age_min = int(input("Âge minimum: "))
        age_max = int(input("Âge maximum: "))
        age_range = (age_min, age_max)
    else:
        age_range = None

    profession_choice = input("Voulez-vous filtrer par profession? (oui/non) ").lower()
    if profession_choice == 'oui':
        profession = input("Entrez la profession: ")
    else:
        profession = None

    specialties_choice = input("Voulez-vous filtrer par spécialisation? (oui/non) ").lower()
    if specialties_choice == 'oui':
        specialties = input("Entrez la spécialisation: ")
    else:
        specialties = None

    return age_range, profession, specialties


def main():
    age_range, profession, specialties = get_user_input()
    result = filter_data(age_range, profession, specialties)
    print("Résultats filtrés:")
    print(result)


if __name__ == "__main__":
    main()