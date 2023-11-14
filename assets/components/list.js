import React from "react";
import ReactDOM from "react-dom/client";
import { styled } from '@mui/material/styles';
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
import FolderIcon from '@mui/icons-material/Folder';
import DeleteIcon from '@mui/icons-material/Delete';
import Box from '@mui/material/Box';

const Demo = styled('div')(({ theme }) => ({
    backgroundColor: theme.palette.background.paper,
  }));

function generate(element) {
    return [0, 1, 2, 4].map((value) =>
    React.cloneElement(element, {
        key: value,
    }),
    );
}


      

function MyList() {
    return(
        <Box sx={{ flexGrow: 1, maxWidth: '100%' }}>
            <Grid item xs={12} md={6}>
                <Typography sx={{ mt: 4, mb: 2 }} variant="h6" component="div">
                Icon with text
                </Typography>
                <Demo>
                    <List >
                        {generate(
                            <ListItem>
                                <ListItemIcon>
                                    <FolderIcon />
                                </ListItemIcon>
                                <ListItemText primary="Single-line item" />
                            </ListItem>,
                        )}
                    </List>
                </Demo>
            </Grid>
        </Box>
    );
}
export default MyList;
