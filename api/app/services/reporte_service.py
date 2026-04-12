import io
from typing import List
from reportlab.lib.pagesizes import letter
from reportlab.lib import colors
from reportlab.platypus import SimpleDocTemplate, Table, TableStyle, Paragraph, Spacer
from reportlab.lib.styles import getSampleStyleSheet
from reportlab.lib.units import inch
from openpyxl import Workbook
from docx import Document
from docx.shared import Pt
from docx.enum.text import WD_ALIGN_PARAGRAPH
import pandas as pd


def generar_pdf_ventas(labels: List[str], data: List[float], total: float) -> io.BytesIO:
    """Genera un PDF con el reporte de ventas por periodo."""
    buffer = io.BytesIO()
    doc = SimpleDocTemplate(buffer, pagesize=letter)
    elements = []
    
    styles = getSampleStyleSheet()
    title_style = styles["Heading1"]
    title_style.alignment = 1  # Center
    
    elements.append(Paragraph("Reporte de Ventas por Periodo", title_style))
    elements.append(Spacer(1, 0.2 * inch))
    
    # Tabla de datos
    table_data = [["Mes", "Ventas ($)"]]
    for label, value in zip(labels, data):
        table_data.append([label, f"${value:,.2f}"])
    
    table_data.append(["TOTAL", f"${total:,.2f}"])
    
    table = Table(table_data)
    table.setStyle(TableStyle([
        ('BACKGROUND', (0, 0), (-1, 0), colors.grey),
        ('TEXTCOLOR', (0, 0), (-1, 0), colors.whitesmoke),
        ('ALIGN', (0, 0), (-1, -1), 'CENTER'),
        ('FONTNAME', (0, 0), (-1, 0), 'Helvetica-Bold'),
        ('FONTSIZE', (0, 0), (-1, 0), 12),
        ('BOTTOMPADDING', (0, 0), (-1, 0), 12),
        ('BACKGROUND', (0, 1), (-1, -1), colors.beige),
        ('GRID', (0, 0), (-1, -1), 1, colors.black),
    ]))
    
    elements.append(table)
    doc.build(elements)
    buffer.seek(0)
    return buffer


def generar_xlsx_ventas(labels: List[str], data: List[float], total: float) -> io.BytesIO:
    """Genera un archivo XLSX con el reporte de ventas por periodo."""
    buffer = io.BytesIO()
    df = pd.DataFrame({
        "Mes": labels + ["TOTAL"],
        "Ventas ($)": data + [total]
    })
    df.to_excel(buffer, index=False, engine='openpyxl')
    buffer.seek(0)
    return buffer


def generar_docx_ventas(labels: List[str], data: List[float], total: float) -> io.BytesIO:
    """Genera un archivo DOCX con el reporte de ventas por periodo."""
    buffer = io.BytesIO()
    doc = Document()
    
    # Título
    title = doc.add_heading('Reporte de Ventas por Periodo', 0)
    title.alignment = WD_ALIGN_PARAGRAPH.CENTER
    
    # Tabla
    table = doc.add_table(rows=1, cols=2)
    table.style = 'Table Grid'
    
    # Encabezados
    hdr_cells = table.rows[0].cells
    hdr_cells[0].text = 'Mes'
    hdr_cells[1].text = 'Ventas ($)'
    
    # Datos
    for label, value in zip(labels, data):
        row_cells = table.add_row().cells
        row_cells[0].text = label
        row_cells[1].text = f"${value:,.2f}"
    
    # Total
    total_row = table.add_row().cells
    total_row[0].text = "TOTAL"
    total_row[1].text = f"${total:,.2f}"
    
    doc.save(buffer)
    buffer.seek(0)
    return buffer


def generar_pdf_pedidos(pedidos: List[dict]) -> io.BytesIO:
    """Genera un PDF con el reporte de pedidos."""
    buffer = io.BytesIO()
    doc = SimpleDocTemplate(buffer, pagesize=letter)
    elements = []
    
    styles = getSampleStyleSheet()
    title_style = styles["Heading1"]
    title_style.alignment = 1
    
    elements.append(Paragraph("Reporte de Pedidos", title_style))
    elements.append(Spacer(1, 0.2 * inch))
    
    table_data = [["ID", "Estado", "Total", "Fecha"]]
    for p in pedidos:
        table_data.append([str(p["id"]), p["estado"], f"${p['total']:.2f}", p["fecha"]])
    
    table = Table(table_data)
    table.setStyle(TableStyle([
        ('BACKGROUND', (0, 0), (-1, 0), colors.grey),
        ('TEXTCOLOR', (0, 0), (-1, 0), colors.whitesmoke),
        ('ALIGN', (0, 0), (-1, -1), 'CENTER'),
        ('FONTNAME', (0, 0), (-1, 0), 'Helvetica-Bold'),
        ('FONTSIZE', (0, 0), (-1, 0), 10),
        ('BOTTOMPADDING', (0, 0), (-1, 0), 12),
        ('BACKGROUND', (0, 1), (-1, -1), colors.beige),
        ('GRID', (0, 0), (-1, -1), 1, colors.black),
    ]))
    
    elements.append(table)
    doc.build(elements)
    buffer.seek(0)
    return buffer


def generar_xlsx_pedidos(pedidos: List[dict]) -> io.BytesIO:
    """Genera un XLSX con el reporte de pedidos."""
    buffer = io.BytesIO()
    df = pd.DataFrame(pedidos)
    df.to_excel(buffer, index=False, engine='openpyxl')
    buffer.seek(0)
    return buffer


def generar_docx_pedidos(pedidos: List[dict]) -> io.BytesIO:
    """Genera un DOCX con el reporte de pedidos."""
    buffer = io.BytesIO()
    doc = Document()
    
    title = doc.add_heading('Reporte de Pedidos', 0)
    title.alignment = WD_ALIGN_PARAGRAPH.CENTER
    
    table = doc.add_table(rows=1, cols=4)
    table.style = 'Table Grid'
    
    hdr_cells = table.rows[0].cells
    hdr_cells[0].text = 'ID'
    hdr_cells[1].text = 'Estado'
    hdr_cells[2].text = 'Total'
    hdr_cells[3].text = 'Fecha'
    
    for p in pedidos:
        row_cells = table.add_row().cells
        row_cells[0].text = str(p["id"])
        row_cells[1].text = p["estado"]
        row_cells[2].text = f"${p['total']:.2f}"
        row_cells[3].text = p["fecha"]
    
    doc.save(buffer)
    buffer.seek(0)
    return buffer


def generar_pdf_inventario(inventario: List[dict]) -> io.BytesIO:
    """Genera un PDF con el reporte de inventario."""
    buffer = io.BytesIO()
    doc = SimpleDocTemplate(buffer, pagesize=letter)
    elements = []
    
    styles = getSampleStyleSheet()
    title_style = styles["Heading1"]
    title_style.alignment = 1
    
    elements.append(Paragraph("Reporte de Inventario", title_style))
    elements.append(Spacer(1, 0.2 * inch))
    
    table_data = [["ID", "Autoparte", "Stock Actual", "Stock Mínimo"]]
    for item in inventario:
        table_data.append([
            str(item.get("autoparte_id", "")),
            item.get("nombre", ""),
            str(item.get("stock_actual", 0)),
            str(item.get("stock_minimo", 0))
        ])
    
    table = Table(table_data)
    table.setStyle(TableStyle([
        ('BACKGROUND', (0, 0), (-1, 0), colors.grey),
        ('TEXTCOLOR', (0, 0), (-1, 0), colors.whitesmoke),
        ('ALIGN', (0, 0), (-1, -1), 'CENTER'),
        ('FONTNAME', (0, 0), (-1, 0), 'Helvetica-Bold'),
        ('FONTSIZE', (0, 0), (-1, 0), 10),
        ('BOTTOMPADDING', (0, 0), (-1, 0), 12),
        ('BACKGROUND', (0, 1), (-1, -1), colors.beige),
        ('GRID', (0, 0), (-1, -1), 1, colors.black),
    ]))
    
    elements.append(table)
    doc.build(elements)
    buffer.seek(0)
    return buffer


def generar_xlsx_inventario(inventario: List[dict]) -> io.BytesIO:
    """Genera un XLSX con el reporte de inventario."""
    buffer = io.BytesIO()
    df = pd.DataFrame(inventario)
    df.to_excel(buffer, index=False, engine='openpyxl')
    buffer.seek(0)
    return buffer


def generar_docx_inventario(inventario: List[dict]) -> io.BytesIO:
    """Genera un DOCX con el reporte de inventario."""
    buffer = io.BytesIO()
    doc = Document()
    
    title = doc.add_heading('Reporte de Inventario', 0)
    title.alignment = WD_ALIGN_PARAGRAPH.CENTER
    
    table = doc.add_table(rows=1, cols=4)
    table.style = 'Table Grid'
    
    hdr_cells = table.rows[0].cells
    hdr_cells[0].text = 'ID'
    hdr_cells[1].text = 'Autoparte'
    hdr_cells[2].text = 'Stock Actual'
    hdr_cells[3].text = 'Stock Mínimo'
    
    for item in inventario:
        row_cells = table.add_row().cells
        row_cells[0].text = str(item.get("autoparte_id", ""))
        row_cells[1].text = item.get("nombre", "")
        row_cells[2].text = str(item.get("stock_actual", 0))
        row_cells[3].text = str(item.get("stock_minimo", 0))
    
    doc.save(buffer)
    buffer.seek(0)
    return buffer
