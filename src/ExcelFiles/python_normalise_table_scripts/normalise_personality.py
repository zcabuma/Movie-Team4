import csv

with open('personalityTypes.csv', 'w', newline='') as writeto:
    writer = csv.writer(writeto)
    writer.writerow(['userID', 'openness', 'agreeableness', 'emotional_stability','conscientiousness','extraversion', 'assigned_metric','assigned_condition', 'is_personalised', 'enjoy_watching'])

with open('personalityRatings.csv', 'w', newline='') as writeto:
    writer = csv.writer(writeto)
    writer.writerow(['userID', 'movieID', 'rating'])

with open('personality-data.csv') as pFile:
    readCSV=csv.reader(pFile, delimiter= ',')
    first = True

    for row in readCSV:
        if first:
            first = False
        else:
            userID = row[0]
            #print(row[1:8])
            length = len(row)
            row = [x.strip() for x in row]
            row[1:6] = [float(x) for x in row[1:6]]
            #print(row[1:8])
            with open('personalityTypes.csv', 'a+', newline='') as writePersonality:
                writer = csv.writer(writePersonality)
                writer.writerow([userID, row[1], row[2], row[3], row[4], row[5], row[6], row[7], int(row[length-2]), int(row[length-1])])

            index = 8
            for x in range(12):
                with open('personalityRatings.csv', 'a+', newline='') as writeRating:
                    writer = csv.writer(writeRating)
                    writer.writerow([userID, int(row[index]), float(row[index+1])])
                    index += 2

print("DONE")
                
                                    
            
