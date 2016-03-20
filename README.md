# Ikhtiyaar
*For submission to __KPApps: The Khyber-Pakhtunkhwa Apps Challenge__*

*Ikhtiyaar* is an initiative to address the corruption and transparency issues prevalent in our system of government. According to the Corruption Perceptions Index (CPI) 2013, Pakistan ranked at a staggeringly low 127 among 175 countries which, both ironically and sadly, is still the best ranking we have been able to achieve so far. Since our last government, the statistics have improved a little, but there is still a need for more drastic measures to be taken on a government scale.

The goal of this project is to provide a technological means for solving the aforementioned issues in our country, and hopefully collaborate with the KPK provincial government to aid us in implementing this in the future. The aim is to improve transparency, accountability and inclusiveness of government institutions and processes, and moreover, to allow for easy communication between the government institutions and the poor and marginalized people.

## About the project
A prototype for a website where users can give their feedback by posting their issues/complaints online and keep updated about other people’ problems and concerns in their area.

Facebook Graph API is used to get information about the user posting the complaint. Users can simply login using their Facebook IDs, saving them from remembering extra passwords. An additional option for posting anonymously can be added later on.

While lodging complaints, users have the option of including up to 5 photos with the complaint. They also have to select a category and provide their location. A partial voting system is included through which users can vote on complaints increasing their priority.

## Future work
Comments and a proper voting system.

**Admin panel:** Administrator should have access to a dashboard where they can view all complaints, sorted into relevant categories. The admin should be able to respond to a complaint, and change its status once the issue is resolved.

**SMS feature:** An SMS service could be added, to enable users to post complaints using only their cell-phones without the need to visit the website. Users would have the option to select how and when they should receive notifications about any updates.

**Complaint statistics:** Statistics could be generated on the website, for example, on daily, weekly or monthly etc. basis, with the option of filtering by category and location.

**Integration with Twitter:** Tweets by the government officials to be automatically displayed on the website, integrating their current mode of communication with our system, making the process of posting updates effortless for them.

## Installation
The website is dependant on the following libraries:
- `Facebook PHP SDK v4` (https://github.com/facebook/facebook-php-sdk-v4)
- `Guzzle, PHP HTTP Client` (https://github.com/guzzle/guzzle). 

The dependancies are defined using [Composer](https://getcomposer.org/). Simply run the following command in the project root to install both of the libraries:

```sh
composer install
```

Please note that you have to install [Composer](https://getcomposer.org/) in your system first.

## Developed by
- Hassan Ahmed
- Sadiq Khan
- Salman Haider
