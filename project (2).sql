-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 12:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `content`, `created_at`) VALUES
(3, 1, 1, 'comment one ', '2025-04-16 01:45:16');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `image`, `created_at`) VALUES
(1, 1, 'hello', '67ff03990514e.jfif', '2025-04-16 01:10:49'),
(6, 101, 'Hi everyone! I\'m a passionate Full Stack Developer with 3 years of hands-on experience, specializing in Node.js and building scalable, high-performance web applications. I graduated with a degree in Business Information Systems, which gives me a strong foundation in both tech and business logic.\r\n\r\nI’m currently looking for new opportunities where I can grow, contribute, and work with a dynamic and innovative team. I’m open to full-time or remote positions and excited to bring my problem-solving mindset and technical skills to new challenges.\r\n\r\n🔧 Tech Skills: Node.js, Express.js, MongoDB, JavaScript, REST APIs, and more.\r\n💼 Experience: 3+ years working on full stack applications in collaborative environments.\r\n🎓 Education: Bachelor\'s in Business Information Systems.\r\n\r\nFeel free to connect or reach out via DM if you know of any opportunities.', NULL, '2025-04-23 02:05:08'),
(7, 101, '\r\nAs someone who\'s always working on leveling up and finding the right career path, I’m really thankful for platforms like Hyrnet.\r\n\r\nIt’s more than just a job board — it’s a space that helps you develop your skills, connect with amazing companies, and actually get seen by employers who are looking for talent like you.\r\n\r\nIf you\'re a developer (or in tech in general) and you\'re not on Hyrnet yet — you\'re seriously missing out! 🚀\r\nBig thanks to the team behind it for making the job search process smarter and more human 🙌\r\n\r\n', '68084c1ba4f1d.png', '2025-04-23 02:10:35'),
(10, 3, 'Hello everyone,\r\nI am currently seeking a full-time or freelance opportunity as a Graphic Designer. I have a strong background in visual identity design, digital and print advertising, and visual content creation for social media platforms.\r\nMy strengths include:\r\nCreativity and innovation in delivering design concepts.\r\nHigh attention to detail and commitment to deadlines.\r\nProficiency in professional design software such as Photoshop, Illustrator, and InDesign.\r\nExcellent teamwork and communication skills across different departments.\r\nI am excited to join a passionate team where I can contribute my expertise and continue developing my skills.\r\nIf you know of any suitable opportunities, I would greatly appreciate it if you could reach out to me via direct message or email.\r\n', NULL, '2025-04-26 19:03:31'),
(11, 4, 'Hello everyone,\r\nI am currently seeking a full-time or freelance opportunity as a Back-end .NET Core Developer. I have a strong background in developing web applications using .NET Core, working with databases, and designing and building efficient APIs.\r\nMy strengths include:\r\nWriting clean, maintainable code following best coding practices.\r\nAdvanced experience with databases such as SQL Server and Entity Framework.\r\nStrong problem-solving and analytical skills.\r\nExcellent teamwork and communication abilities with a commitment to deadlines.\r\nA continuous passion for learning and keeping up with the latest technologies.\r\nI am excited to join a professional team where I can contribute my experience and continue growing my skills.\r\nIf you know of any suitable opportunities, I would appreciate it if you could reach out to me via direct message or email.\r\nThank you for your support! 🚀\r\n\r\n', NULL, '2025-04-26 19:07:15'),
(12, 5, 'Sales & Business Development Representative                                                                                                                                                             Job Details\r\nExperience Needed:1 to 4 yearsCareer Level:Entry Level (Junior Level / Fresh Grad)\r\nEducation Level:Bachelor\'s DegreeSalary:8000 to 10000 EGP Per Month, Commission And Bonuses Based On The KPI Achievement And The Performance\r\nJob Categories:Business Development (https://wuzzuf.net/a/Business-Jobs-in-Egypt?filters%5Bcountry%5D%5B0%5D=Egypt)\r\nSales/Retail (https://wuzzuf.net/a/Sales-Jobs-in-Egypt?filters%5Bcountry%5D%5B0%5D=Egypt)                                                                                                          Job Description                                                                                                        As a Sales & Business Development Representative, you will play a pivotal role in the growth of our B2B platform that sells supplies to the HORECA sector (Hotels, Restaurants, Cafes). You will be responsible for managing supplier registrations, enhancing product descriptions, and increasing both our supplier base and client businesses using our platform.\r\nAdditionally, you will promote our consultancy services focused on project and product management for technology and software projects within the manufacturing industry. You’ll identify target companies, connect with decision-makers, and schedule meetings to introduce our consultancy solutions.', NULL, '2025-04-26 19:18:29'),
(13, 5, 'Real Estate Sales Agent                                                                                          Job Details\r\nExperience Needed:0 to 2 yearsCareer Level:Entry Level (Junior Level / Fresh Grad)\r\nEducation Level:Bachelor\'s DegreeSalary:Confidential\r\nJob Categories:Business Development (https://wuzzuf.net/a/Business-Jobs-in-Egypt?filters%5Bcountry%5D%5B0%5D=Egypt)\r\nSales/Retail (https://wuzzuf.net/a/Sales-Jobs-in-Egypt?filters%5Bcountry%5D%5B0%5D=Egypt)\r\n                                                                                                                                  Job Description\r\nIdentify and connect with potential clients through outbound prospecting, networking, and referrals\r\nDevelop and maintain a portfolio of clients, building strong long-term relationships\r\nUnderstand clients’ needs and present suitable products or services\r\nNegotiate terms and close deals that benefit all parties involved\r\nMonitor market trends and stay informed on industry developments\r\nCollaborate with internal teams to ensure client satisfaction and smooth transactions\r\nPrepare and maintain accurate records of client interactions, transactions, and forecasts using CRM software\r\nAttend industry events, conferences, and meetings to build connections and stay up-to-date\r\nComply with all relevant laws, regulations, and company policies', NULL, '2025-04-26 19:23:05'),
(14, 6, 'Hello everyone,\r\nI’m currently seeking a new opportunity as a Sales & Business Development Representative! 🚀\r\nThroughout my journey, I have developed strong skills in:\r\n✨ Building and nurturing client relationships to turn opportunities into successful partnerships.\r\n✨ Achieving sales targets and expanding into new markets.\r\n✨ High-level communication and precise client needs analysis.\r\n✨ A continuous passion for learning modern sales strategies and business growth.\r\nI am ready to join a driven team where I can contribute to real growth and new success stories!\r\nIf you know of any suitable opportunities, I’d love to hear from you. 🙏\r\n', NULL, '2025-04-26 19:28:56'),
(15, 7, 'Hello everyone,\r\nI am actively seeking an opportunity as a Full Stack Developer, where I can leverage my skills to build powerful, end-to-end applications.\r\nWith experience in front-end technologies like React and Angular, combined with solid back-end expertise in .NET Core and Node.js, I have developed a full vision for creating smart and efficient solutions.\r\nWhat sets me apart:\r\nDeep understanding of the project lifecycle from planning to delivery.\r\nStrong analytical thinking and efficient problem-solving skills.\r\nA passion for learning new technologies and improving code quality.\r\nTeam spirit with a clear focus on achieving impactful results.\r\nI’m ready to take on new challenges and contribute to building innovative projects that deliver real value.\r\nIf you know of any opportunities that align, feel free to reach out! 🚀\r\n\r\n', '680d3677e4028.jpg', '2025-04-26 19:39:35'),
(16, 105, 'Digital Marketing Manager     \r\n                                                                                                                                                                                             Job Details\r\nExperience Needed:7 to 12 yearsCareer Level:Manager\r\nEducation Level:Bachelor\'s DegreeSalary:Confidential\r\nJob Categories:Creative/Design/Art\r\nMarketing/PR/AdvertisingMedia/Journalism/Publishing   \r\n Job Description\r\nPlan, budget and execute all digital marketing, including SEO/SEM, marketing database, social media and display advertising campaigns.\r\nLead generation through digital platforms .\r\nRebranding our company by designing, building and maintaining our social media presence.\r\nMeasure and report performance of all digital marketing campaigns, and assess against goals (ROI and KPIs) .\r\nConduct ongoing market and competitor analysis to identify trends, benchmark performance, and uncover opportunities for differentiation and growth.\r\nIdentify trends and insights, and optimize spend and performance based on the insights.\r\nBrainstorm new and creative growth strategies.\r\nCollaborate with internal teams to create smooth and effective plans implementation .\r\nPlan and oversee promotional events, property launches, and open houses.\r\nUtilize strong analytical ability to evaluate end-to-end customer experience across multiple channels and customer touch points.\r\nBuild and maintain relationships with media, advertising agencies, and key partners.\r\nProvide leadership and supervision to the marketing team .\r\nJob Requirements\r\nBCs degree in marketing or a related field.\r\n7+ years of proven work experience in digital marketing for real estate with at least 1 year as manager .\r\nUp-to-date with the latest trends and best practices in online marketing and measurement .\r\nHighly creative with experience in identifying target audiences and devising digital campaigns that engage, inform and motivate .\r\nExcellent in written and spoken English .\r\nExcellent project management , organizational and presentation skills.\r\nCreativity with a strong eye for design and brand consistency.\r\nEvent management experience.\r\nExceptional verbal and written communication skills', NULL, '2025-04-26 19:50:16'),
(17, 105, 'General Accountant                                                                                                                                                                                                                              \r\n\r\nJob Details\r\nExperience Needed:4 to 5 yearsCareer Level:Experienced (Non-Manager)\r\nEducation Level:Not SpecifiedSalary:Confidential\r\nJob Categories:Accounting/Finance (https://wuzzuf.net/a/Accounting-Finance-Jobs-in-Egypt?filters%5Bcountry%5D%5B0%5D=Egypt)\r\nBusiness Development (https://wuzzuf.net/a/Business-Jobs-in-Egypt?filters%5Bcountry%5D%5B0%5D=Egypt)Sales/Retail (https://wuzzuf.net/a/Sales-Jobs-in-Egypt?filters%5Bcountry%5D%5B0%5D=Egypt)\r\nJob Description\r\nOversee day-to-day operations\r\nDesign strategy and set goals for growth\r\nMaintain budgets and optimize expenses\r\nSet policies and processes\r\nEnsure employees work productively and develop professionally\r\nOversee recruitment and training of new employees\r\nEvaluate and improve operations and financial performance\r\nDirect the employee assessment process\r\nPrepare regular reports for upper management\r\nEnsure staff follows health and safety regulations\r\nProvide solutions to issues (e.g. profit decline, employee conflicts, loss of business to competitors)\r\nJob Requirements\r\nProven experience as a General Manager or similar executive roleExperience in planning and budgeting\r\nKnowledge of business process and functions (finance, HR, procurement, operations etc.)\r\nStrong analytical ability\r\nExcellent communication skills\r\nOutstanding organizational and leadership skills\r\nProblem-solving aptitude\r\nBSc/BA in Business or relevant field; MSc/MA is a plus', '680d3e2647d3c.jpg', '2025-04-26 20:12:22'),
(18, 102, 'Hello everyone,\r\nI am currently seeking a new opportunity as a Motion Graphic Designer, where I can bring ideas to life through creativity and dynamic visuals.\r\nI have strong experience in creating interactive videos, animations, and compelling visual content that tells powerful stories.\r\n\r\nWhat sets me apart:\r\nA visual creativity that transforms complex ideas into simple and inspiring messages.\r\nHands-on expertise with tools like After Effects, Premiere Pro, and Illustrator.\r\nKeen attention to detail with a deep understanding of visual rhythm and timing.\r\nA passionate drive to craft movements and designs that leave a lasting impression.\r\nExcited to join a team that believes in the power of visuals and motion to deliver impactful messages!\r\nIf you know of any suitable opportunities, I’d love to connect! 🎥✨\r\n\r\n', NULL, '2025-04-26 20:27:30'),
(19, 104, 'Hi HYRNET ! I’m a creative Content Creator with experience in producing engaging multimedia content, including videos, blogs, and social media posts. Skilled in storytelling and audience engagement strategies.\r\n\r\nLooking for opportunities to create compelling content that resonates with audiences. Open to freelance and full-time roles.', '680d4389b0a25.jpg', '2025-04-26 20:35:21'),
(20, 106, 'Hi everyone! I’m a Digital Marketing with experience in campaign management, content creation, and analytics. Skilled in tools like Google Analytics and Mailchimp.\r\n\r\nLooking for opportunities to coordinate marketing efforts and drive brand awareness.', NULL, '2025-04-26 20:42:07'),
(21, 101, 'Hello everyone,\r\nI’m a Full Stack Developer currently seeking a new opportunity to apply my skills and expertise in building complete solutions from front-end to back-end.\r\nI am proficient in modern technologies such as:\r\nFront-end: React.js, Next.js, HTML, CSS, JavaScript.\r\nBack-end: .NET Core, Node.js, APIs.\r\nDatabases: SQL Server, MongoDB.\r\nCode management and teamwork: Git, Agile/Scrum.\r\nI believe development is not just about writing code — it’s about creating real, impactful solutions.\r\nI’m excited to join a team that values innovation, continuous growth, and collaboration.\r\nReady for new challenges and eager to make an impact! 🔥\r\nIf you know of any opportunities, feel free to reach out!\r\n\r\n', NULL, '2025-04-26 20:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `post_chats`
--

CREATE TABLE `post_chats` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_views` int(11) DEFAULT 0,
  `post_impressions` int(11) DEFAULT 0,
  `country` varchar(255) DEFAULT 'Egypt',
  `mobile` varchar(20) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` enum('male','female','prefer_not_to_say') DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_image`, `job_title`, `created_at`, `profile_views`, `post_impressions`, `country`, `mobile`, `birthdate`, `gender`, `address`) VALUES
(1, 'Ahmed', 'ahmedrashad@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', '67ff1626a445c.png', 'backend dev', '2025-04-16 00:43:17', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(3, 'Sara Mohamed', 'sara@example.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'imgr5.png', 'Graphic Designer', '2025-04-22 23:49:04', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(4, 'Ahmed Ali', 'ahmed@example.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'imgr6.png', 'Back-end .Net Core Developmer', '2025-04-22 23:53:06', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(5, 'Nour Hassan', 'nour@example.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'imgr3.png', 'Human Resources Generalist', '2025-04-22 23:53:06', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(6, 'Omar Youssef', 'omar@example.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'omar.jpg', 'Sales & Business Development Representative', '2025-04-22 23:53:06', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(7, 'Laila Adel', 'laila@example.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'laila.jpg', 'Full Stack Developer', '2025-04-22 23:53:06', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(8, 'Mohamed Hany', 'mohamed@example.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'mohamed.jpg', 'Content Creator', '2025-04-22 23:53:06', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(9, 'Sara Mohamed', 'sara.mohamed@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'sara.jpg', 'UI/UX Web Designer                                                                                 ', '2025-04-22 23:56:47', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(10, 'Ahmed Ali', 'ahmed.ali@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'ahmed.jpg', 'Call Center Agent', '2025-04-22 23:56:47', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(11, 'Nour Hassan', 'nour.hassan@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'nour.jpg', 'General Accountant', '2025-04-22 23:56:47', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(12, 'Omar Youssef', 'omar.youssef@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'omar.jpg', 'Full Stack Developer', '2025-04-22 23:56:47', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(13, 'Laila Adel', 'laila.adel@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'laila.jpg', 'Front End Developer', '2025-04-22 23:56:47', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(14, 'Mohamed Hany', 'mohamed.hany@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'mohamed.jpg', 'Accountant', '2025-04-22 23:56:47', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(15, 'Jeremy Melad', 'jeremy.melad@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'jeremy.jpg', 'UI/UX Designer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(16, 'Kareem Gmal', 'kareem.gmal@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'kareem.jpg', 'Front end Developer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(17, 'Angela Magdy', 'angela.magdy@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'angela.jpg', 'Mobile App Developer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(18, 'Mark Edward', 'mark.Edward@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'mark.jpg', 'QA Tester', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(19, 'Manar Ahmed', 'ManarAhmed@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'manar.jpg', 'Product Manager', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(78, 'Hala Adel', 'halaadel@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'hala.jpg', 'Product Manager', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(79, 'Aya Gamal', 'ayagamal@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'aya.jpg', 'UI/UX Designer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(80, 'Alaa Nabil', 'alaanabil@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'alaa.jpg', 'Front End Developer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(81, 'Ahmed Shaker', 'ahmedshaker@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'ahmed.jpg', 'Accountant', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(82, 'Marawan Mahmoud', 'marawanma@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'marwan.jpg', 'DevOps Engineer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(83, 'Mohammed Ashraf', 'mohammedashraf@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'mohammed.jpg', 'Artist', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(84, 'Caroline Azmy', 'carolineazmy@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'caroline.jpg', 'Software Engineer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(85, 'Basmala Emad', 'basmalaemad@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'basmala.jpg', 'Radiologist Specialist', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(86, 'Nour Khalid', 'nourkhalid@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'nour.jpg', 'Software Engineer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(87, 'Walaa Salah', 'walaasalah@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'walaa.jpg', 'Economic Analyst', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(88, 'Sabrin Metwaly', 'sabrinmetwaly@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'sabrin.jpg', 'Civil Engineer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(89, 'Hany Hisham', 'hanyhisham@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'hany.jpg', 'Photographer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(90, 'Hamed Fathallah', 'Hamedfathallah@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'hamed.jpg', 'Translator', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(91, 'Saed Hisan', 'saedhisan@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'saed.jpg', 'Computer Engineer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(92, 'Ayman Saed', 'aymansaed@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'ayman.jpg', 'Marketing Specialist', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(101, 'Shahd Emad', 'shahdemadeldin17@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'shahd emad.jpg', 'Full Stack Developer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(102, 'Shaimaa Khaled', 'Shaimaa.khaled@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'shaimaa .jpg', 'Motion graphic designer', '2025-04-22 21:57:58', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(104, 'Dai Tobar', 'daiehabtobar@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'Dai Tobar.jpg', 'Content Creator', '2025-04-24 22:14:32', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(105, 'Sama khaled', 'samakhaled3334@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'sama.jpg', 'HR', '2025-04-24 22:19:25', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(106, 'Maya Ibrahim Alsayed', 'mayaibrahim2517@gmail.com', '$2y$10$GKBx5jVOKjjLTQ.K6Krqbe9Wj.QSWcLDeV/.1ikwwXRzxl2.yFc8u', 'maya.jpg', 'Digital marketing specialist ', '2025-04-26 20:39:56', 0, 0, 'Egypt', NULL, NULL, NULL, NULL),
(107, 'hala', 'hala17@gmail.com', '$2y$10$gntJUqbTkusxSSYDQCQCLe9Pwn1sbNqyQ3nC6QB22zHds1XAAQOaG', NULL, NULL, '2025-05-03 22:50:25', 0, 0, 'Egypt', '01027259524', '2025-05-04', 'female', 'etay');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follower_id` (`follower_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_chats`
--
ALTER TABLE `post_chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `post_chats`
--
ALTER TABLE `post_chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_chats`
--
ALTER TABLE `post_chats`
  ADD CONSTRAINT `post_chats_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_chats_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_chats_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
