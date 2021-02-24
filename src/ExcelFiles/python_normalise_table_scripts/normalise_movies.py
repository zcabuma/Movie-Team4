import csv


lookup = {}
with open('genres.csv') as genresfile:
    readCSV=csv.reader(genresfile, delimiter= ',')
    first = True
    for row in readCSV:
        print(row)
        if first:
            first = False
        else:
            lookup[row[1]] = row[0]
print(lookup)

with open('movies_genres.csv', 'w', newline='') as writeto:
    writer = csv.writer(writeto)
    writer.writerow(['movieID', 'genreID'])
    

##with open('movies_genres_old.csv') as everything:
##    readCSV = csv.reader(everything, delimiter = ',')
##    first = True
##
##    for row in readCSV:
##        
##        if first:
##            first = False
##        else:
##            #print(row)
##            movieID =row[0]
##            allgenres = row[1].split('|')
##            for x in allgenres:
##                x.strip()
##                with open('movies_genres.csv', 'a+',  newline='') as writeto:
##                    writer = csv.writer(writeto)
##                    writer.writerow([movieID, lookup[x]])

print("DONE")
