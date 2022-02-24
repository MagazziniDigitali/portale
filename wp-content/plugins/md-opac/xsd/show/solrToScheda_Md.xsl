<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:include href="solrToScheda_Sast.xsl"/>
    
    <xsl:template match="arr[@name='provenienzaOggetto_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Provenienza Oggetto
            </td>
                <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                        
                            <xsl:copy-of select="child::text()"/>
                       
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tipoContenitore_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Tipo Contenitore
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='objectIdentifier_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Identificativo
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='fileType_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                File Type
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='actualFileName_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Actual File Name
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='sha1_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Sha1
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='size_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Size
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='mimeType_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Mime Type
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='promon_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Pronom
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='rights_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Rights
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">showScheda('<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                    
			<xsl:if test="../../rights">
				 <xsl:copy-of select="../../rights/child::text()"/>
			</xsl:if>
			<xsl:if test="not(../../rights)">
                        	<xsl:copy-of select="child::text()"/>
			</xsl:if>
                   
                    </a>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tarIndex_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Tar Index
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='relationshipType_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                RelationShip Type
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventID_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Event ID
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventType_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Event Type
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventDate_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Event Date
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventDetail_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Event Detail
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='eventOutCome_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Event Out Come
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='agentDepositante_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Agent Depositante
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <a>
                        <xsl:attribute name="onclick">findTeca('id','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute>
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    </a>
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='agentSoftware_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Agent Software
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='nodo_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Nodo
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tipoDocumento_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Tipo Documento
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='bni_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Bni
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='pubblicazione_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Luogo di pubblicazione
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='soggetto_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Soggetto
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='contributo_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Contributo
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='data_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Data Pubblicazione
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='tiporisorsa_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Tipo Risorsa
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='formato_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Formato
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='fonte_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Fonte
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='relazione_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Relazione
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='copertura_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Copertura
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='gestionediritti_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Link a risorsa archiviata
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='biblioteca_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Biblioteca
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='inventario_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Inventario
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='piecegr_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Piece gr
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='piecedt_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Pice Dt
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='piecein_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Piece In
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
    
    <xsl:template match="arr[@name='indexed_show']">
        <tr class="table-border">
            <td class="col-md-3 label-dettaglio label-dettaglio-border">
                Data ora Indicizzazione
            </td>
            <td class="col-md-9 label-dettaglio-border">
                <xsl:for-each select="str">
                    <!--a>
                        <xsl:attribute name="onclick">findTeca('collocazione','<xsl:copy-of select="translate(child::text(),$apos,'')" />');</xsl:attribute -->
                    
                        <xsl:copy-of select="child::text()"/>
                   
                    <!-- /a -->
                    <br/>
                </xsl:for-each>
            </td>
        </tr>
    </xsl:template>
</xsl:stylesheet>
