# Magento 2 Comments Module

## Overview

This module for Magento 2 interacts with approximately 50% of the key functionalities within the platform. It aims to provide a structured approach to common tasks and serve as a helpful resource for both new and experienced developers.

## Motivation

During my journey with Magento 2, I encountered various poor practices, including overreliance on the Object Manager and disregard for service contracts. In my quest to learn the right way, I found few quality resources that followed Magento's best practices, often getting lost in misleading forum discussions.

This module is not only a reference for my own work but also a guide for junior engineers navigating the complexities of Magento 2.

## Contribution

I’m always striving to improve. If you notice any issues or outdated practices in this module, I encourage you to submit a pull request!
## Compatibility

- **Magento Version**: 2.4.7
- **PHP Version**: 8.3

This module leverages many of Magento’s recommended practices and incorporates new features introduced in PHP.

## Installation

To install this module, follow these steps:

1. Clone the repository:
   ```bash
   git clone https://github.com/Amilram2001/Comments.git
   ```

2. Place the module in the `app/code` directory:
   ```
   app/code/Practice/Comments
   ```

3. In the root folder of your Magento installation, run the following commands:
   ```bash
   bin/magento setup:upgrade
   bin/magento setup:di:compile
   ```

4. If necessary (not required in development mode), deploy using:
   ```bash
   bin/magento s:s:d -f
   ```

## Accessing Controllers

You can access the controllers through the following endpoints:

- **View All Comments**:
  ```
  comments/index/index
  ```
  This endpoint allows for actions such as creating, updating, and deleting comments.

- **Add a Comment**:
  ```
  comments/index/create
  ```

## Acknowledgments

A heartfelt thank you to all senior engineers and the supportive community on Reddit who provide feedback on this module. Your insights are invaluable!
