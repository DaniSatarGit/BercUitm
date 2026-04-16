# 🍪 BercUITM – Reviewer Management System

A web-based reviewer management system built using PHP & MySQL for ethical application review tracking and management.

---

## 🚀 Overview

**BercUITM** is a comprehensive system developed to streamline the ethical application review process at Universiti Teknologi MARA (UiTM).

The system enables **coordinators** to assign applications to **reviewers**, who then conduct detailed evaluations using a structured BERC form. All submissions are automatically tracked, stored in JSON format for flexibility, and converted to PDF for record-keeping.

---

## ⭐ Features

### 👨‍💼 Coordinator
- ✅ User login & dashboard
- ✅ View all applications
- ✅ Assign reviewers to applications
- ✅ Track review status (Pending → Completed)
- ✅ Monitor reviewer assignments
- ✅ Search & filter applications

### 👨‍💻 Reviewer
- ✅ User login & dashboard
- ✅ View assigned applications
- ✅ Access structured review form (BERC)
- ✅ Fill evaluation details (A, B, C sections)
- ✅ Submit review with automatic PDF generation
- ✅ Download review PDF
- ✅ Track submission status

### 🔧 System
- ✅ Role-based access control
- ✅ Automatic status tracking
- ✅ PDF generation & storage
- ✅ JSON-based data storage (flexible & scalable)
- ✅ Email notifications (optional)
- ✅ Session management

---

## 🛠️ Tech Stack

| Component | Technology |
|-----------|-----------|
| **Backend** | PHP (Native) |
| **Database** | MySQL / MariaDB |
| **Frontend** | HTML5, CSS3, JavaScript |
| **UI Framework** | Bootstrap 5 |
| **PDF Generation** | FPDF Library |
| **Development Server** | XAMPP (Apache & MySQL) |

---

## 🗄️ Database Tables

```sql
-- Core Tables
reviewer              -- Reviewer accounts
coordinator           -- Coordinator accounts
researcher            -- Researcher accounts
secretariat           -- Secretariat accounts

-- Application Tables
coordinator_application   -- Main application data
reviewer_application      -- Assignment tracking
reviews                   -- Full review records (JSON)
project_evaluations       -- Legacy review data

-- Status Tables
approved_application      -- Approved applications
rejected_application      -- Rejected applications
approved_exemption        -- Approved exemptions
rejected_exemption        -- Rejected exemptions
```

---

## 🔐 Default Test Account

### Coordinator
```
Username: coordinatorID
Password: password123
```

### Reviewer
```
Username: reviewerID
Password: password123
```

---

## 🚀 How to Run

### 1️⃣ Setup Project
```bash
# Move project to XAMPP htdocs
Move-Item -Path ".\BercUitm" -Destination "C:\xampp\htdocs\"

# Or manually copy to:
# C:\xampp\htdocs\BercUitm\
```

### 2️⃣ Database Setup
```bash
# Start MySQL in XAMPP Control Panel

# Import migration file
mysql -u root -p bercuitm < create_reviews_table.sql

# Or use phpMyAdmin:
# - Select database: bercuitm
# - Tab: Import
# - Choose: create_reviews_table.sql
# - Click: Import
```

### 3️⃣ Start Server
```bash
# Start XAMPP Control Panel
# Click: Apache (Start)
# Click: MySQL (Start)
```

### 4️⃣ Access Application
```
http://localhost/BercUitm/
```

---

## 📂 Project Structure

```
BercUitm/
├── index.php                          # Login page
├── config.php                         # Database configuration
├── databaseConnect.php                # DB connection
│
├── Coordinator/
│   ├── CoordinatorPage.php           # Dashboard
│   ├── application.php               # Manage applications
│   ├── assign_reviewer_application.php
│   └── image/
│
├── Reviewer/
│   ├── ReviewerPage.php              # Dashboard
│   ├── application.php               # View assignments
│   ├── submitBerc9.php               # Process submissions
│   ├── reviews_pdf/                  # PDF storage
│   ├── Application/
│   │   ├── view_application.php      # Review form interface
│   │   ├── berc9N.php               # BERC form template
│   │   └── application.php
│   └── fpdf/                         # FPDF library
│
├── Admin/
│   ├── register_reviewer.php
│   ├── register_coordinator.php
│   └── setupAdmin.php
│
├── create_reviews_table.sql          # Migration file
├── Readme.md                         # Documentation
└── GITHUB_SETUP.md                   # Git guide
```

---

## 📌 Workflow Diagram

```
┌─────────────────────────────────────────────────────────────┐
│               BercUITM Review Process Flow                  │
└─────────────────────────────────────────────────────────────┘

COORDINATOR PHASE
├─ Login
├─ Browse Applications
├─ Search/Filter
└─ Assign Reviewer → Status: PENDING
                │
REVIEWER PHASE  │
├─ Login        │
├─ View Dashboard
├─ Select Assigned Application
├─ Fill BERC Form:
│  ├─ Section A: Research Methods
│  ├─ Section B: Subject Types
│  ├─ Section C: BERC Evaluation
│  ├─ Section D: Form Status (BERC2/3/5)
│  └─ Final Decision
└─ Submit → Status: COMPLETED
                │
SYSTEM PHASE    │
├─ Validate Data
├─ INSERT into reviews (JSON)
├─ Generate PDF
├─ UPDATE reviewer_application.status
└─ Send PDF to reviewer
                │
COORDINATOR REVIEW
├─ Status Updated: PENDING → COMPLETED
├─ View Review Details
└─ Take Next Action
```

---

## ✨ Key Features Explained

### 📋 Reviewer Assignment
- Coordinators assign applications to reviewers
- Status tracked in `reviewer_application` table
- One application per reviewer (unique constraint)

### 📝 BERC Review Form
```
Part A: Research Methods (Checkboxes)
  ├─ Interviews, Focus Groups, Questionnaires
  ├─ Controlled Trials, Observation
  ├─ Exercise Intensity, Others
  
Part B: Subject Types (Checkboxes)
  ├─ Children, Vulnerable Groups
  ├─ Healthy Subjects, Trained Persons
  
Part C: BERC Evaluation (Radio + Comments)
  ├─ Title, Background, Problem Statement
  ├─ Objectives, Benefits, Dates
  ├─ Location, Design, Criteria
  ├─ Sample Size, Flowchart, Analysis
  
Part D: Status & Decision
  ├─ BERC2, BERC3, BERC5 Status
  ├─ Final Decision (Approve/Revise/Return)
  └─ Modifications (if needed)
```

### 📄 PDF Generation
- Automatic PDF creation using FPDF
- Stored in: `Reviewer/reviews_pdf/`
- Naming: `<project_title>_review_<timestamp>.pdf`
- Downloadable immediately after submission

### 💾 Data Storage
- **JSON Format**: All form data stored as JSON in `reviews.review_data`
- **Advantages**: Flexible schema, easy to add fields, audit trail
- **Backward Compatibility**: Data also in `project_evaluations` table

---

## 🔄 Status Flow

```
Application Created
    ↓
Assigned to Reviewer → Status: PENDING
    ↓
Reviewer Fills Form
    ↓
Reviewer Submits → Status: COMPLETED
    ↓
PDF Generated & Stored
    ↓
Coordinator Views Results
```

---

## 📊 Verification Commands

### Check Reviews in Database
```sql
SELECT * FROM reviews ORDER BY id DESC LIMIT 5;
```

### Check Assignment Status
```sql
SELECT id, application_id, reviewer_id, status, assigned_at
FROM reviewer_application
WHERE application_id = <app_id>;
```

### View Generated PDFs
```powershell
dir "C:\xampp\htdocs\BercUitm\Reviewer\reviews_pdf\"
```

---

## 🎯 Future Improvements

- ✨ Add email notifications for new assignments
- ✨ Implement advanced search & filtering
- ✨ Add review history & revision tracking
- ✨ Improve UI/UX design with modern themes
- ✨ Add export to Excel functionality
- ✨ Implement audit logging
- ✨ Add bulk assignment feature
- ✨ Mobile-responsive design optimization

---

## 📸 Screenshots

### 🏠 Login Page
```
[Screenshot Coming Soon]
```

### 👨‍💼 Coordinator Dashboard
```
[Screenshot Coming Soon]
```

### 📋 Application Assignment
```
[Screenshot Coming Soon]
```

### 👨‍💻 Reviewer Dashboard
```
[Screenshot Coming Soon]
```

### 📝 Review Form (BERC)
```
[Screenshot Coming Soon]
```

### 📄 Generated PDF
```
[Screenshot Coming Soon]
```

---

## 🐛 Troubleshooting

| Problem | Solution |
|---------|----------|
| "Connection failed" | Ensure MySQL is running in XAMPP |
| "Database not found" | Import `create_reviews_table.sql` file |
| "Submit button not working" | Check browser console for JS errors |
| "PDF not downloading" | Verify `reviews_pdf/` folder permissions |
| "Status stuck on Pending" | Check `submitBerc9.php` error logs |
| "Can't see assigned applications" | Verify assignment in Coordinator UI |

---

## 📚 Documentation Files

- `Readme.md` – Main documentation (this file)
- `README_REVIEWER_SYSTEM.md` – Detailed technical guide
- `GITHUB_SETUP.md` – Git & GitHub setup instructions
- `create_reviews_table.sql` – Database migration

---

## 👨‍💼 About This Project

Developed as part of **internship training** at UiTM, focusing on:

- 🎯 Real-world workflow implementation
- 🗄️ Database design & optimization
- 🔧 PHP backend development
- 📋 Form handling & validation
- 📄 Dynamic PDF generation
- 🔄 Status tracking systems

---

## 📞 Support & Contact

For questions or issues, please:
1. Check the troubleshooting section
2. Review detailed docs in `README_REVIEWER_SYSTEM.md`
3. Check code comments for inline documentation

---

## 📄 License

This project is developed as part of UiTM internship training.

---

**Version:** 1.0  
**Last Updated:** April 2026  
**Status:** ✅ Production Ready  
**Author:** [Your Name]