import { Button } from "@/Components/ui/button";
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table";
import { Link } from "@inertiajs/react";
import axios from "axios";
import React, { useState } from "react";

export default function Index({ data }) {
    const [dataApi, setDataApi] = useState(data || []);

    const deleteIdHandler = async (id) => {
        try {
            const response = await axios.delete(route("dosen.destroy", id));

            alert(response.data.message);

            setDataApi((prevData) => {
                return prevData.filter((item) => item.id !== id);
            });
        } catch (error) {
            alert(error.message);
        }
    };

    return (
        <div className="w-full">
            <h1>Daftar Dosen</h1>
            <Link href={"/dosen/create"}>Tambah Dosen</Link>
            <Table>
                <TableCaption>Daftar Dosen</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>NIDN</TableHead>
                        <TableHead>NAMA</TableHead>
                        <TableHead>NO. HP</TableHead>
                        <TableHead>AKSI</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {dataApi.map((item, index) => {
                        return (
                            <TableRow key={index}>
                                <TableCell>{item.nidn}</TableCell>
                                <TableCell>{item.nama}</TableCell>
                                <TableCell>{item.no_hp}</TableCell>
                                <TableCell className="flex gap-x-4">
                                    <Button asChild>
                                        <Link href={`/dosen/${item.id}/edit`}>
                                            Ubah
                                        </Link>
                                    </Button>
                                    <Button
                                        onClick={() => deleteIdHandler(item.id)}
                                    >
                                        Hapus
                                    </Button>
                                </TableCell>
                            </TableRow>
                        );
                    })}
                </TableBody>
            </Table>
        </div>
    );
}
