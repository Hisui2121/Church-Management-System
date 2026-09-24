from pathlib import Path

output_path = Path(r"c:\Users\Bryze Sia Ayapana\Documents\Church-Management-System\church-management-system-modules.pdf")

content_lines = [
    "Church Management System - Current Modules",
    "",
    "1. Authentication / Login Module",
    "   Main Feature: Allows users to log in, log out, and recover/reset passwords.",
    "   Attributes: Email, Password (hashed), Name, Role/Permission, Remember Token",
    "",
    "2. Member Management Module",
    "   Main Feature: Stores and manages church members and their personal profiles.",
    "   Attributes: First Name, Last Name, Birthdate, Gender, Contact Number, Email, Address, Profile Photo, Member Status, Member Type, Date Joined",
    "",
    "3. User Account / Role Module",
    "   Main Feature: Manages system users and assigns permissions or roles.",
    "   Attributes: Name, Email, Password, Phone, Address Details, Member Type, Baptism Status, Ministry Interest, Role",
    "",
    "4. Ministry Module",
    "   Main Feature: Creates ministries and assigns members to them.",
    "   Attributes: Ministry Name, Description, Assigned Members, Member Role in Ministry, Joined Date",
    "",
    "5. Events Module",
    "   Main Feature: Manages church events or programs.",
    "   Attributes: Event Name, Description, Image, Date, Time",
    "",
    "6. Announcements Module",
    "   Main Feature: Publishes announcements for members and admins.",
    "   Attributes: Title, Body, Image, Created By, Active Status, Published Date",
    "",
    "7. Attendance Module",
    "   Main Feature: Records attendance and checks in members during services.",
    "   Attributes: Member ID, User ID, Service Session ID, Service ID, Date, Checked-in Time, Present/Absent Status, Recorded By",
    "",
    "8. Service Session Module",
    "   Main Feature: Starts and manages service sessions for attendance tracking.",
    "   Attributes: Session Status, Start Time, End Time, Session Date, Pastor, Service Title, Bible Verse",
    "",
    "9. Attendance Report Module",
    "   Main Feature: Generates attendance reports and export-ready summaries.",
    "   Attributes: Attendance Records, Service Session Data, Member Data, Report Type/Export Format",
    "",
    "10. Banner Module",
    "   Main Feature: Manages homepage banners or promotional images.",
    "   Attributes: Image, Title, Description, Order, Active Status, Created By",
    "",
    "11. Messaging Module",
    "   Main Feature: Sends and receives internal messages between users.",
    "   Attributes: Sender, Receiver, Subject, Message Body, Read Status, Read Date",
    "",
    "12. Order / Request Module",
    "   Main Feature: Handles user requests and admin approval status.",
    "   Attributes: User, Title, Description, Status, Admin Notes, Resolved Date",
    "",
    "13. Audit Log Module",
    "   Main Feature: Tracks important user actions for system accountability.",
    "   Attributes: User, Action, Table Name, Record ID, Description, Page",
    "",
    "14. Dashboard Module",
    "   Main Feature: Provides an overview of key information for members and admins.",
    "   Attributes: User Info, Recent Activity, Attendance Status, Session Status",
]


def escape_pdf_text(text: str) -> str:
    return text.replace('\\', '\\\\').replace('(', '\\(').replace(')', '\\)')


def build_pdf(lines):
    lines_per_page = 40
    pages = []
    current = []
    for line in lines:
        current.append(line)
        if len(current) >= lines_per_page:
            pages.append(current)
            current = []
    if current:
        pages.append(current)

    objects = []
    page_refs = []

    for page_lines in pages:
        page_content_lines = []
        y = 760
        for idx, line in enumerate(page_lines):
            if idx == 0:
                page_content_lines.append(f"BT /F1 14 Tf 50 {y} Td ({escape_pdf_text(line)}) Tj ET")
            else:
                page_content_lines.append(f"BT /F1 10 Tf 50 {y} Td ({escape_pdf_text(line)}) Tj ET")
            y -= 14

        content_stream = "\n".join(page_content_lines)
        content_stream = content_stream.encode('latin-1', 'replace').decode('latin-1')
        content_obj = f"{len(objects) + 1} 0 obj\n<< /Length 0 >>\nstream\n{content_stream}\nendstream\nendobj\n"
        # placeholder length fixed below
        objects.append(content_obj)

    # Rebuild content objects with correct lengths
    content_objs = []
    for i, page_lines in enumerate(pages):
        page_content_lines = []
        y = 760
        for idx, line in enumerate(page_lines):
            if idx == 0:
                page_content_lines.append(f"BT /F1 14 Tf 50 {y} Td ({escape_pdf_text(line)}) Tj ET")
            else:
                page_content_lines.append(f"BT /F1 10 Tf 50 {y} Td ({escape_pdf_text(line)}) Tj ET")
            y -= 14

        content_stream = "\n".join(page_content_lines)
        content_stream = content_stream.encode('latin-1', 'replace').decode('latin-1')
        length = len(content_stream.encode('latin-1'))
        content_obj = f"{len(objects) + 1} 0 obj\n<< /Length {length} >>\nstream\n{content_stream}\nendstream\nendobj\n"
        content_objs.append(content_obj)

    # Need object numbering to match references
    # Build final object list with catalog, pages, page objs, content objs, font obj
    obj_list = []
    catalog_obj = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n"
    obj_list.append(catalog_obj)

    pages_obj = "2 0 obj\n<< /Type /Pages /Kids ["
    pages_obj += " ".join([f"{3 + i * 2} 0 R" for i in range(len(pages))]) + "] /Count " + str(len(pages)) + " >>\nendobj\n"
    obj_list.append(pages_obj)

    font_obj = f"{3 + len(pages) * 2} 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n"

    page_objs = []
    content_obj_numbers = []
    for i, page_lines in enumerate(pages):
        page_num = 3 + i * 2
        content_num = page_num + 1
        content_obj_numbers.append(content_num)
        page_obj = f"{page_num} 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 {font_obj.split()[0]} 0 R >> >> /Contents {content_num} 0 R >>\nendobj\n"
        page_objs.append(page_obj)

    # Rebuild with correct numbers
    obj_list = [catalog_obj, pages_obj]
    for i, page_obj in enumerate(page_objs):
        obj_list.append(page_obj)
    for content_obj in content_objs:
        obj_list.append(content_obj)
    obj_list.append(font_obj)

    # Fix page object references to actual font object number
    font_num = len(pages) * 2 + 3
    obj_list = []
    obj_list.append("1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n")
    obj_list.append("2 0 obj\n<< /Type /Pages /Kids [" + " ".join([f"{3 + i * 2} 0 R" for i in range(len(pages))]) + "] /Count " + str(len(pages)) + " >>\nendobj\n")
    for i, page_lines in enumerate(pages):
        page_num = 3 + i * 2
        content_num = page_num + 1
        obj_list.append(f"{page_num} 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 {font_num} 0 R >> >> /Contents {content_num} 0 R >>\nendobj\n")
    for i, page_lines in enumerate(pages):
        page_num = 3 + i * 2
        content_num = page_num + 1
        y = 760
        stream_lines = []
        for idx, line in enumerate(page_lines):
            if idx == 0:
                stream_lines.append(f"BT /F1 14 Tf 50 {y} Td ({escape_pdf_text(line)}) Tj ET")
            else:
                stream_lines.append(f"BT /F1 10 Tf 50 {y} Td ({escape_pdf_text(line)}) Tj ET")
            y -= 14
        content_stream = "\n".join(stream_lines)
        content_stream = content_stream.encode('latin-1', 'replace').decode('latin-1')
        length = len(content_stream.encode('latin-1'))
        obj_list.append(f"{content_num} 0 obj\n<< /Length {length} >>\nstream\n{content_stream}\nendstream\nendobj\n")
    obj_list.append(f"{font_num} 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n")

    pdf = bytearray(b"%PDF-1.4\n")
    offsets = [0]
    for obj in obj_list:
        offsets.append(len(pdf))
        pdf.extend(obj.encode('latin-1'))

    xref_offset = len(pdf)
    pdf.extend(f"xref\n0 {len(obj_list) + 1}\n".encode('latin-1'))
    pdf.extend(b"0000000000 65535 f \n")
    for i in range(1, len(obj_list) + 1):
        offset = offsets[i]
        pdf.extend(f"{offset:010d} 00000 n \n".encode('latin-1'))
    pdf.extend(f"trailer\n<< /Size {len(obj_list) + 1} /Root 1 0 R >>\nstartxref\n{xref_offset}\n%%EOF\n".encode('latin-1'))
    output_path.write_bytes(pdf)


build_pdf(content_lines)
print(f"Created PDF: {output_path}")
